<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\InvoiceMail;

class InvoiceController extends Controller
{
    /**
     * List invoices.
     * Admin users see all invoices for their company.
     * Non-admin users see only invoices for their branch within the company.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Invoice::with('customer')->where('company_id', $user->company_id);

        // Branch-level users should only see their branch invoices
        if ($user->role !== 'admin') {
            $query->where('branch_id', $user->branch_id);
        }

        // search by invoice number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($c) use ($search) {
                        $c->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Customer filter (make sure customer belongs to company)
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Date range
        if ($request->filled('from')) {
            $query->whereDate('issue_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('issue_date', '<=', $request->to);
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['paid', 'unpaid', 'partial'])) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'amount_high':
                $query->orderBy('total_amount', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('total_amount', 'asc');
                break;
            case 'due_date':
                $query->orderBy('due_date', 'asc');
                break;
            default:
                $query->latest();
        }

        $invoices = $query->paginate(15)->withQueryString();

        // Stats scoped to the same visibility (company + branch restriction)
        $statsQuery = Invoice::where('company_id', $user->company_id);
        if ($user->role !== 'admin') {
            $statsQuery->where('branch_id', $user->branch_id);
        }
        $allInvoices = $statsQuery->get();
        $totalAmount = $allInvoices->sum('total_amount');

        $stats = [
            'paid_count' => $allInvoices->where('status', 'paid')->count(),
            'paid_amount' => $allInvoices->where('status', 'paid')->sum('total_amount'),
            'paid_percentage' => $totalAmount > 0 ? ($allInvoices->where('status', 'paid')->sum('total_amount') / $totalAmount * 100) : 0,

            'unpaid_count' => $allInvoices->where('status', 'unpaid')->count(),
            'unpaid_amount' => $allInvoices->where('status', 'unpaid')->sum('total_amount'),
            'unpaid_percentage' => $totalAmount > 0 ? ($allInvoices->where('status', 'unpaid')->sum('total_amount') / $totalAmount * 100) : 0,

            'partial_count' => $allInvoices->where('status', 'partial')->count(),
            'partial_amount' => $allInvoices->where('status', 'partial')->sum('total_amount'),
            'partial_percentage' => $totalAmount > 0 ? ($allInvoices->where('status', 'partial')->sum('total_amount') / $totalAmount * 100) : 0,
        ];

        // Customers for select dropdown: only company customers (and if branch user, you may want to scope to branch customers – keep company-wide for flexibility)
        $customers = Customer::where('company_id', $user->company_id)
            ->when($user->role !== 'admin', fn($q) => $q->where('branch_id', $user->branch_id))
            ->get();

        return view('invoices.index', compact('invoices', 'stats', 'customers'));
    }

    /**
     * Show create form.
     * Products/customers/units filtered by company (and branch when appropriate).
     */
    public function create()
    {
        $user = auth()->user();

        $products = Product::where('company_id', $user->company_id)->orderBy('name')->get();
        $customers = Customer::where('company_id', $user->company_id)
            ->when($user->role !== 'admin', fn($q) => $q->where('branch_id', $user->branch_id))
            ->orderBy('name')->get();

        // invoice number generation per company (keeps uniqueness within company)
        $last = Invoice::where('company_id', $user->company_id)->latest('id')->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $invoice_number = 'INV-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('invoices.form', compact('products', 'customers', 'invoice_number'));
    }

    /**
     * Store invoice. assigns company_id, branch_id, user_id automatically.
     * Validates items belong to the same company.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')->where(fn($q) => $q->where('company_id', $user->company_id))],
            'invoice_number' => 'required|string',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date',
            'currency' => 'required|string|max:20',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => ['required', 'integer'],
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'vat_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // ensure products exist and belong to the company
            $productIds = collect($validated['items'])->pluck('product_id')->unique()->values()->all();
            $companyProductsCount = Product::whereIn('id', $productIds)
                ->where('company_id', $user->company_id)
                ->count();

            if ($companyProductsCount !== count($productIds)) {
                throw new \Exception('One or more selected products are invalid or do not belong to your company.');
            }

            $items = $validated['items'];
            $subtotal = 0;

            foreach ($items as $key => $item) {
                $qty = (float)($item['quantity'] ?? 0);
                $rate = (float)($item['rate'] ?? 0);
                $discount = (float)($item['discount'] ?? 0);

                $base = $qty * $rate;
                $items[$key]['amount'] = round($base - $discount, 2);
                $subtotal += $items[$key]['amount'];
            }

            $globalDiscount = (float)($validated['discount'] ?? 0);
            $afterDiscount = max(0, $subtotal - $globalDiscount);

            $vatAmount = (float)($validated['vat_amount'] ?? 0);
            $total = round($afterDiscount + $vatAmount, 2);

            $invoice = Invoice::create([
                'company_id' => $user->company_id,
                'branch_id' => $user->branch_id,
                'user_id' => $user->id,
                'customer_id' => $validated['customer_id'],
                'invoice_number' => $validated['invoice_number'],
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'] ?? null,
                'currency' => $validated['currency'],
                'discount' => $globalDiscount,
                'notes' => $validated['notes'] ?? null,
                'total_amount' => $total,
                'vat_amount' => round($vatAmount, 2),
                'status' => 'unpaid',
            ]);

            foreach ($items as $itemData) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'company_id' => $user->company_id,
                    'branch_id' => $user->branch_id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'unit' => $itemData['unit'] ?? '',
                    'rate' => $itemData['rate'],
                    'discount' => $itemData['discount'] ?? 0,
                    'tax_percent' => 0,
                    'amount' => $itemData['amount'],
                ]);
            }

            DB::commit();

            return redirect()->route('invoice.show', ['invoice' => $invoice])->with('success', 'Invoice created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    /**
     * Edit invoice form.
     */
    public function edit(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $invoice->load('items');

        $user = auth()->user();
        $products = Product::where('company_id', $user->company_id)->orderBy('name')->get();
        $customers = Customer::where('company_id', $user->company_id)
            ->when($user->role !== 'admin', fn($q) => $q->where('branch_id', $user->branch_id))
            ->orderBy('name')
            ->get();

        return view('invoices.form', compact('invoice', 'products', 'customers'));
    }

    /**
     * Update invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $user = auth()->user();

        $validated = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')->where(fn($q) => $q->where('company_id', $user->company_id))],
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date',
            'currency' => 'required|string|max:20',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'vat_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Validate products belong to company
            $productIds = collect($validated['items'])->pluck('product_id')->unique()->values()->all();
            $companyProductsCount = Product::whereIn('id', $productIds)
                ->where('company_id', $user->company_id)
                ->count();

            if ($companyProductsCount !== count($productIds)) {
                throw new \Exception('One or more selected products are invalid or do not belong to your company.');
            }

            $items = $validated['items'];
            $subtotal = 0;

            foreach ($items as $key => $item) {
                $rate = (float)($item['rate'] ?? 0);
                $qty = (float)($item['quantity'] ?? 0);
                $discount = (float)($item['discount'] ?? 0);

                $base = $rate * $qty;
                $items[$key]['amount'] = round($base - $discount, 2);
                $subtotal += $items[$key]['amount'];
            }

            $globalDiscount = (float)($validated['discount'] ?? 0);
            $afterDiscount = max(0, $subtotal - $globalDiscount);
            $vatAmount = (float)($validated['vat_amount'] ?? 0);
            $total = round($afterDiscount + $vatAmount, 2);

            $invoice->update([
                'customer_id' => $validated['customer_id'],
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'] ?? null,
                'currency' => $validated['currency'],
                'notes' => $validated['notes'] ?? null,
                'discount' => $globalDiscount,
                'total_amount' => $total,
                'vat_amount' => round($vatAmount, 2),
            ]);

            // replace items
            $invoice->items()->delete();
            foreach ($items as $itemData) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'company_id' => $user->company_id,
                    'branch_id' => $user->branch_id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'unit' => $itemData['unit'] ?? '',
                    'rate' => $itemData['rate'],
                    'discount' => $itemData['discount'] ?? 0,
                    'tax_percent' => 0,
                    'amount' => $itemData['amount'],
                ]);
            }

            DB::commit();

            return redirect()->route('invoice.show', ['invoice' => $invoice->id])->with('success', 'Invoice updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update invoice: ' . $e->getMessage()]);
        }
    }

    /**
     * Show invoice.
     */
    public function show(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load('items.product', 'customer', 'user', 'branch');

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Download invoice PDF.
     */
    public function download(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load(['customer', 'items.product', 'user', 'branch']);

        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(fn($item) => ($item->quantity * $item->rate * $item->tax_percent) / 100);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Stream PDF to browser.
     */
    public function view(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load(['customer', 'items.product', 'user', 'branch']);

        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(fn($item) => ($item->quantity * $item->rate * $item->tax_percent) / 100);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Send invoice by email (with PDF attachment).
     */
    public function send(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        if (!$invoice->customer->email) {
            return redirect()->back()->with('error', 'Customer does not have an email address.');
        }

        $invoice->load(['customer', 'items.product', 'user', 'branch']);

        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(fn($item) => ($item->quantity * $item->rate * $item->tax_percent) / 100);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);

        try {
            Mail::to($invoice->customer->email)
                ->send(new InvoiceMail($invoice, $pdf->output()));

            $invoice->update(['is_sent' => true]);

            \Log::info('Invoice email sent', [
                'invoice_id' => $invoice->id,
                'customer_email' => $invoice->customer->email,
                'sent_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Invoice sent successfully to ' . $invoice->customer->email);
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice email', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Failed to send invoice: ' . $e->getMessage());
        }
    }

    /**
     * Delete invoice (with authorization).
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        try {
            $invoice->items()->delete();
            $invoice->delete();

            return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete invoice: ' . $e->getMessage());
        }
    }

    /**
     * Authorization helper:
     * - invoice.company_id must equal user's company
     * - if user is not admin -> invoice.branch_id must equal user's branch
     */
    private function authorizeAccess(Invoice $invoice)
    {
        $user = auth()->user();

        if ($invoice->company_id !== $user->company_id) {
            abort(403, 'Unauthorized access: company mismatch.');
        }

        if ($user->role !== 'admin' && $invoice->branch_id !== $user->branch_id) {
            abort(403, 'Unauthorized access: branch mismatch.');
        }
    }

    /**
     * Payment initialization (Paystack) — invoice must be accessible by user.
     */
    public function pay(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $merchant = $invoice->user;

        // Use merchant-provided Paystack keys (decrypt if stored encrypted)
        $paystackPublic = $merchant->paystack_public_key ? decrypt($merchant->paystack_public_key) : config('services.paystack.public');
        $paystackSecret = $merchant->paystack_secret_key ? decrypt($merchant->paystack_secret_key) : config('services.paystack.secret');

        $paystack = new \Yabacon\Paystack($paystackSecret);
        $response = $paystack->transaction->initialize([
            'amount' => $invoice->total_amount * 100,
            'email' => $invoice->customer->email,
            'reference' => 'INV-' . $invoice->id . '-' . time(),
            'callback_url' => route('invoice.callback', $invoice->id),
        ]);

        return redirect($response->data->authorization_url);
    }

    /**
     * Mark invoice fully paid (admin/accountant action).
     */
    public function markPaid(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $invoice->paid = $invoice->total_amount;
        $invoice->status = 'paid';
        $invoice->paid_at = now();
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice marked as fully paid.');
    }

    /**
     * Record a partial payment.
     */
    public function markPartial(Request $request, Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $request->validate([
            'partial_amount' => 'required|numeric|min:0.01|max:' . ($invoice->total_amount - $invoice->paid),
            'payment_date' => 'nullable|date',
            'payment_notes' => 'nullable|string|max:500'
        ]);

        $partialAmount = $request->partial_amount;
        $newPaidAmount = $invoice->paid + $partialAmount;

        $invoice->paid = $newPaidAmount;
        $invoice->status = $newPaidAmount >= $invoice->total_amount ? 'paid' : 'partial';
        $invoice->save();

        return redirect()->route('invoice.show', $invoice)
            ->with('success', 'Partial payment of ' . $invoice->currency . ' ' . number_format($partialAmount, 2) . ' recorded successfully!');
    }

    /**
     * Update Paystack keys for authenticated user
     */
    public function updatePaystackKeys(Request $request)
    {
        $request->validate([
            'paystack_public_key' => 'nullable|string',
            'paystack_secret_key' => 'nullable|string',
        ]);

        auth()->user()->update([
            'paystack_public_key' => $request->paystack_public_key,
            'paystack_secret_key' => $request->paystack_secret_key,
        ]);

        return back()->with('success', 'Paystack keys updated successfully!');
    }

    /**
     * Handle Paystack callback for invoice payments.
     */
    public function handleCallback(Request $request, Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $merchant = $invoice->user;
        $paystackSecret = $merchant->paystack_secret_key ? decrypt($merchant->paystack_secret_key) : config('services.paystack.secret');
        $paystack = new \Yabacon\Paystack($paystackSecret);

        $reference = $request->query('reference');

        try {
            $tranx = $paystack->transaction->verify(['reference' => $reference]);

            if ($tranx->data->status === 'success') {
                $invoice->status = 'paid';
                $invoice->paid = $invoice->total_amount;
                $invoice->payment_method = 'paystack';
                $invoice->paid_at = now();
                $invoice->save();

                return redirect()->route('invoice.paid', $invoice->id)->with('success', 'Payment successful! Invoice marked as paid.');
            }

            return redirect()->route('invoice.show', $invoice->id)->with('error', 'Payment not successful. Please try again.');
        } catch (\Exception $e) {
            return redirect()->route('invoice.show', $invoice->id)->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    /**
     * Financial report scoped to company and branch access.
     */
    public function financialReport(Request $request)
    {
        $user = auth()->user();

        $query = Invoice::where('company_id', $user->company_id);
        if ($user->role !== 'admin') {
            $query->where('branch_id', $user->branch_id);
        }
        $invoices = $query->get();

        // Group by month
        $monthlySales = $invoices->groupBy(fn($i) => $i->issue_date->format('Y-m'))->map(fn($items) => [
            'invoice_count' => $items->count(),
            'total_amount' => $items->sum('total_amount'),
            'paid_amount' => $items->where('status', 'paid')->sum('total_amount'),
        ]);

        // Quarter
        $quarterlySales = $invoices->groupBy(function ($item) {
            $month = (int)$item->issue_date->format('m');
            $quarter = ceil($month / 3);
            return $item->issue_date->format('Y') . '-Q' . $quarter;
        })->map(fn($items) => [
            'invoice_count' => $items->count(),
            'total_amount' => $items->sum('total_amount'),
            'paid_amount' => $items->where('status', 'paid')->sum('total_amount'),
        ]);

        // Yearly
        $yearlySales = $invoices->groupBy(fn($i) => $i->issue_date->format('Y'))->map(fn($items) => [
            'invoice_count' => $items->count(),
            'total_amount' => $items->sum('total_amount'),
            'paid_amount' => $items->where('status', 'paid')->sum('total_amount'),
        ]);

        $totalRevenue = $invoices->sum('total_amount');
        $totalPaid = $invoices->where('status', 'paid')->sum('total_amount');

        return view('invoices.report', compact('monthlySales', 'quarterlySales', 'yearlySales', 'totalRevenue', 'totalPaid'));
    }

    /**
     * Public pay (for customers visiting payment link) - still ensure invoice is part of company
     */
    public function publicPay(Invoice $invoice)
    {
        // Do NOT require the authenticated user here: we only check invoice company/branch consistency if necessary.
        // However, for security, ensure invoice belongs to a company (always true) and proceed with merchant's keys.
        $merchant = $invoice->user;
        $paystackSecret = $merchant->paystack_secret_key ? decrypt($merchant->paystack_secret_key) : config('services.paystack.secret');

        $paystack = new \Yabacon\Paystack($paystackSecret);

        $response = $paystack->transaction->initialize([
            'amount' => $invoice->total_amount * 100,
            'email' => $invoice->customer->email,
            'reference' => 'INV-' . $invoice->id . '-' . time(),
            'callback_url' => route('invoice.public.callback', $invoice->id),
        ]);

        return redirect($response->data->authorization_url);
    }

    /**
     * Public callback for payment link.
     */
    public function publicCallback(Request $request, Invoice $invoice)
    {
        $merchant = $invoice->user;
        $paystackSecret = $merchant->paystack_secret_key ? decrypt($merchant->paystack_secret_key) : config('services.paystack.secret');
        $paystack = new \Yabacon\Paystack($paystackSecret);

        $reference = $request->query('reference');

        try {
            $tranx = $paystack->transaction->verify(['reference' => $reference]);
            if ($tranx->data->status === 'success') {
                $invoice->update([
                    'paid' => $invoice->total_amount,
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                return view('invoices.payment-success', compact('invoice'));
            }
        } catch (\Exception $e) {
            \Log::error('Public callback verification error', ['error' => $e->getMessage()]);
        }

        return view('invoices.payment-failed', compact('invoice'));
    }

    /**
     * Payment success page
     */
    public function paymentSuccess(Invoice $invoice)
    {
        return view('invoices.payment-success', compact('invoice'));
    }

    /**
     * Receipt view (paid invoices only)
     */
    public function receipt(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        if (!$invoice->paid) {
            abort(404, 'Receipt not available for unpaid invoices');
        }

        $invoice->load(['customer', 'items.product', 'user', 'branch']);

        if (request()->has('download')) {
            $pdf = Pdf::loadView('invoices.receipt', compact('invoice'))->setPaper('a4', 'portrait');
            return $pdf->download('receipt-' . $invoice->invoice_number . '.pdf');
        }

        return view('invoices.receipt', compact('invoice'));
    }


}
