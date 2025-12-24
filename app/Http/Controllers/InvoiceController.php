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
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Http;

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

        if ($user->role !== 'admin') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('from')) $query->whereDate('issue_date', '>=', $request->from);
        if ($request->filled('to')) $query->whereDate('issue_date', '<=', $request->to);

        if ($request->filled('status') && in_array($request->status, ['paid', 'unpaid', 'partial'])) {
            $query->where('status', $request->status);
        }

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

        $statsQuery = Invoice::where('company_id', $user->company_id);
        if ($user->role !== 'admin') $statsQuery->where('branch_id', $user->branch_id);
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

        $customers = Customer::where('company_id', $user->company_id)
            ->when($user->role !== 'admin', fn($q) => $q->where('branch_id', $user->branch_id))
            ->get();

        return view('invoices.index', compact('invoices', 'stats', 'customers'));
    }

    public function create()
    {
        $user = auth()->user();

        $products = Product::where('company_id', $user->company_id)->orderBy('name')->get();
        $customers = Customer::where('company_id', $user->company_id)
            ->when($user->role !== 'admin', fn($q) => $q->where('branch_id', $user->branch_id))
            ->orderBy('name')->get();

        $last = Invoice::where('company_id', $user->company_id)->latest('id')->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $invoice_number = 'INV-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('invoices.form', compact('products', 'customers', 'invoice_number'));
    }

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
            $productIds = collect($validated['items'])->pluck('product_id')->unique()->values()->all();
            $companyProductsCount = Product::whereIn('id', $productIds)->where('company_id', $user->company_id)->count();

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
                'created_by' => auth()->id(),
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
            $this->logActivity('created', $invoice, [], $invoice->toArray());

            return redirect()->route('invoice.show', ['invoice' => $invoice])->with('success', 'Invoice created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

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

            $oldValues = $invoice->toArray();

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
            $this->logActivity('updated', $invoice, $oldValues, $invoice->toArray());

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

    public function show(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load('items.product', 'customer', 'user', 'branch');

        return view('invoices.show', compact('invoice'));
    }

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
        ])->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

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
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

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

    protected function initializePaystack(Invoice $invoice)
    {
        $invoice->load('customer');

        if ($invoice->status === 'paid') {
            abort(403, 'Invoice already paid');
        }

        $reference = 'INV-' . $invoice->id . '-' . uniqid();

        // Amount in kobo
        $amount = (int) ($invoice->total_amount * 100);

        // IMPORTANT: use invoice owner, not auth user
        $paystackSecret = decrypt(
            $invoice->company->merchant->paystack_secret_key
        );

        $response = Http::withToken($paystackSecret)
            ->post('https://api.paystack.co/transaction/initialize', [
                'email'        => $invoice->customer->email,
                'amount'       => $amount,
                'reference'    => $reference,
                'callback_url' => route('invoice.callback', $invoice),
                'metadata'     => [
                    'invoice_id' => $invoice->id,
                ],
            ]);

        $data = $response->json();

        if (!($data['status'] ?? false)) {
            abort(500, 'Unable to initialize payment');
        }

        return redirect()->away($data['data']['authorization_url']);
    }


    public function pay(Invoice $invoice)
    {
        return $this->initializePaystack($invoice);
    }



    public function publicPay(Invoice $invoice)
    {
        return $this->initializePaystack($invoice);
    }

    private function processPayment(Invoice $invoice, float $amount, string $action = 'paid')
    {
        $this->authorizeAccess($invoice);

        $oldValues = $invoice->toArray();

        // Update paid amount
        $newPaid = $invoice->paid + $amount;

        // Determine status
        $status = $newPaid >= $invoice->total_amount ? 'paid' : 'partial';

        $invoice->update([
            'paid' => $newPaid,
            'status' => $status,
            'paid_at' => now(),
        ]);

        // Log activity
        $this->logActivity($action, $invoice, $oldValues, $invoice->toArray());
    }

    public function handleCallback(Request $request, Invoice $invoice)
    {
        $invoice->load('customer');

        try {
            // Assume $request->amount is in cents; adjust if needed
            $amount = isset($request->amount) ? $request->amount / 100 : $invoice->total_amount;

            $this->processPayment($invoice, $amount, 'paid');

            return redirect()->route('invoice.show', $invoice)->with('success', 'Payment successful!');
        } catch (\Throwable $e) {
            return redirect()->route('invoice.show', $invoice)->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function publicCallback(Request $request, Invoice $invoice)
    {
        $invoice->load('customer');

        try {
            // Assume $request->amount is in cents; adjust if needed
            $amount = isset($request->amount) ? $request->amount / 100 : $invoice->total_amount;

            $this->processPayment($invoice, $amount, 'paid_public');

            return redirect()->route('invoice.show', $invoice)->with('success', 'Payment successful!');
        } catch (\Throwable $e) {
            return redirect()->route('invoice.show', $invoice)->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }


    public function markPaid(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        try {
            $oldValues = $invoice->toArray();

            $invoice->update([
                'paid' => $invoice->total_amount,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $this->logActivity('marked_paid', $invoice, $oldValues, $invoice->toArray());

            return redirect()->back()->with('success', 'Invoice marked as paid.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to mark invoice as paid: ' . $e->getMessage());
        }
    }

    public function markPartial(Request $request, Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        // Calculate the remaining amount correctly
        $remainingAmount = $invoice->total_amount - $invoice->paid;

        $validated = $request->validate([
            'partial_amount' => 'required|numeric|min:0.01|max:' . $remainingAmount,
        ]);

        try {
            $oldValues = $invoice->toArray();

            // Add the partial payment to the existing paid amount
            $newPaid = $invoice->paid + $validated['partial_amount'];

            $invoice->update([
                'paid' => $newPaid,
                'status' => $newPaid >= $invoice->total_amount ? 'paid' : 'partial',
            ]);

            $this->logActivity('marked_partial', $invoice, $oldValues, $invoice->toArray());

            return redirect()->back()->with('success', 'Invoice marked as partially paid.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to mark invoice as partially paid: ' . $e->getMessage());
        }
    }



    public function financialReport(Request $request)
    {
        $user = auth()->user();

        $query = Invoice::where('company_id', $user->company_id);

        if ($user->role !== 'admin') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('issue_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('issue_date', '<=', $request->to);
        }

        $invoices = $query->get();

        /* =========================
       SUMMARY TOTALS
    ========================= */
        $totalRevenue = $invoices->sum('total_amount');
        $totalPaid    = $invoices->sum('paid_amount');

        /* =========================
       MONTHLY SALES
    ========================= */
        $monthlySales = $invoices->groupBy(function ($invoice) {
            return $invoice->issue_date->format('Y-m');
        })->map(fn($group) => [
            'total_amount' => $group->sum('total_amount')
        ]);

        /* =========================
       QUARTERLY SALES
    ========================= */
        $quarterlySales = $invoices->groupBy(function ($invoice) {
            return 'Q' . ceil($invoice->issue_date->format('n') / 3)
                . '-' . $invoice->issue_date->format('Y');
        })->map(fn($group) => [
            'total_amount' => $group->sum('total_amount')
        ]);

        /* =========================
       YEARLY BREAKDOWN
    ========================= */
        $yearlySales = $invoices->groupBy(function ($invoice) {
            return $invoice->issue_date->format('Y');
        })->map(fn($group) => [
            'invoice_count' => $group->count(),
            'total_amount'  => $group->sum('total_amount'),
            'paid_amount'   => $group->sum('paid_amount'),
        ]);

        return view('invoices.report', compact(
            'totalRevenue',
            'totalPaid',
            'monthlySales',
            'quarterlySales',
            'yearlySales'
        ));
    }


    private function logActivity($action, $modelInstance, $oldValues = [])
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model' => get_class($modelInstance),
            'model_id' => $modelInstance->id,
            'old_values' => $oldValues,
            'new_values' => $modelInstance->toArray(),
        ]);
    }
}
