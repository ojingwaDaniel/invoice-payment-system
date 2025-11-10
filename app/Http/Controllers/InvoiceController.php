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
use Illuminate\Support\Facades\Http;
use App\Mail\InvoiceMail;
use App\Models\Unit;

class InvoiceController extends Controller
{
    /** ======================
     *  Display all invoices
     *  ====================== */

    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = Invoice::with('customer')->where('user_id', $userId);

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['paid', 'unpaid', 'partial'])) {
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

        $invoices = $query->paginate(15);

        // Stats only for this user
        $allInvoices = Invoice::where('user_id', $userId)->get();
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

        return view('invoices.index', compact('invoices', 'stats'));
    }
    /** ======================
     *  Show create form
     *  ====================== */
    public function create()
    {
        $userId = auth()->id();
        $products = Product::where('user_id', $userId)->orderBy('name')->get();
        $customers = Customer::where('user_id', $userId)->orderBy('name')->get();


        $last = Invoice::where('user_id', $userId)->latest('id')->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $invoice_number = 'INV-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('invoices.form', compact('products', 'customers', 'invoice_number'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date',
            'currency' => 'required|string|max:20',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'vat_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $userId = auth()->id();
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


            $taxRate = (float)($request->tax_rate ?? 0);
            $vatAmount = (float)($validated['vat_amount'] ?? 0);

            $total = round($afterDiscount + $vatAmount, 2);

            $invoice = Invoice::create([
                'user_id' => $userId,
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
            return redirect()->route('invoice.index')->with('success', 'Invoice created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function edit(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load('items');

        $userId = auth()->id();
        $products = Product::where('user_id', $userId)->orderBy('name')->get();
        $customers = Customer::where('user_id', $userId)->orderBy('name')->get();

        return view('invoices.form', compact('invoice', 'products', 'customers'));
    }



    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date',
            'currency' => 'required|string|max:20',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'vat_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $items = $validated['items'];
            $subtotal = 0;


            foreach ($items as $key => $item) {
                $rate = (float)($item['rate'] ?? 0);
                $qty = (float)($item['quantity'] ?? 0);
                $discount = (float)($item['discount'] ?? 0);

                $base = $rate * $qty;
                $items[$key]['amount'] = round($base - $discount, 2);  // Use $key
                $subtotal += $items[$key]['amount'];
            }

            $globalDiscount = (float)($validated['discount'] ?? 0);
            $afterDiscount = max(0, $subtotal - $globalDiscount);

            $taxRate = (float)($request->tax_rate ?? 0);
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

            $invoice->items()->delete();


            foreach ($items as $itemData) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
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
            return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update invoice: ' . $e->getMessage()]);
        }
    }

    public function show(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load('items', 'customer');
        return view('invoices.show', compact('invoice'));
    }
    public function download(Invoice $invoice)
    {

        $invoice->load(['customer', 'items', 'user']);


        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(function ($item) {
            return ($item->quantity * $item->rate * $item->tax_percent) / 100;
        });


        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);


        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }


    public function view(Invoice $invoice)
    {
        $invoice->load(['customer', 'items', 'user']);

        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(function ($item) {
            return ($item->quantity * $item->rate * $item->tax_percent) / 100;
        });

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);

        $pdf->setPaper('a4', 'portrait');


        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function send(Invoice $invoice)
    {

        if (!$invoice->customer->email) {
            return redirect()->back()->with('error', 'Customer does not have an email address.');
        }

        $invoice->load(['customer', 'items', 'user']);


        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(function ($item) {
            return ($item->quantity * $item->rate * $item->tax_percent) / 100;
        });


        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);

        try {
            Mail::to($invoice->customer->email)
                ->send(new InvoiceMail($invoice, $pdf->output()));


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
        try {
            $invoice->delete();
            return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete invoice: ' . $e->getMessage());
        }
    }

    private function authorizeAccess(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }


    public function pay(Invoice $invoice)
    {
        $user = $invoice->user;

        // Use merchant-provided Paystack keys (or fallback to default)
        $paystackPublic = $user->paystack_public_key ?? config('services.paystack.public');
        $paystackSecret = $user->paystack_secret_key ?? config('services.paystack.secret');

        // Initialize transaction using these keys
        $paystack = new \Yabacon\Paystack($paystackSecret);
        $response = $paystack->transaction->initialize([
            'amount' => $invoice->total_amount * 100,
            'email' => $invoice->customer->email,
            'reference' => 'INV-' . $invoice->id . '-' . time(),
            'callback_url' => route('invoice.callback', $invoice->id),
        ]);

        return redirect($response->data->authorization_url);
    }


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
    public function handleCallback(Request $request, Invoice $invoice)
    {
        $user = $invoice->user;

        // Use the same Paystack secret key
        $paystackSecret = $user->paystack_secret_key ?? config('services.paystack.secret');
        $paystack = new \Yabacon\Paystack($paystackSecret);

        // Get the reference Paystack sent back
        $reference = $request->query('reference');

        try {
            // Verify the payment with Paystack
            $tranx = $paystack->transaction->verify(['reference' => $reference]);

            if ($tranx->data->status === 'success') {
                // ✅ Payment successful
                $invoice->status = 'paid';
                $invoice->paid = $invoice->total_amount;
                $invoice->payment_method = 'paystack';
                $invoice->save();

                return redirect()
                    ->route('invoice.show', $invoice->id)
                    ->with('success', 'Payment successful! Invoice marked as paid.');
            } else {
                // ❌ Payment failed or cancelled
                return redirect()
                    ->route('invoice.show', $invoice->id)
                    ->with('error', 'Payment not successful. Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('invoice.show', $invoice->id)
                ->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }
    public function financialReport(Request $request)
    {
        $userId = auth()->id();

        $invoices = Invoice::where('user_id', $userId)->get();

        // Group by month
        $monthlySales = $invoices->groupBy(function ($item) {
            return $item->issue_date->format('Y-m'); // YYYY-MM
        })->map(function ($items) {
            return [
                'invoice_count' => $items->count(),
                'total_amount' => $items->sum('total_amount'),
                'paid_amount' => $items->where('status', 'paid')->sum('total_amount'),
            ];
        });

        // Group by quarter
        $quarterlySales = $invoices->groupBy(function ($item) {
            $month = (int)$item->issue_date->format('m');
            $quarter = ceil($month / 3);
            return $item->issue_date->format('Y') . '-Q' . $quarter;
        })->map(function ($items) {
            return [
                'invoice_count' => $items->count(),
                'total_amount' => $items->sum('total_amount'),
                'paid_amount' => $items->where('status', 'paid')->sum('total_amount'),
            ];
        });

        // Yearly sales
        $yearlySales = $invoices->groupBy(function ($item) {
            return $item->issue_date->format('Y');
        })->map(function ($items) {
            return [
                'invoice_count' => $items->count(),
                'total_amount' => $items->sum('total_amount'),
                'paid_amount' => $items->where('status', 'paid')->sum('total_amount'),
            ];
        });

        $totalRevenue = $invoices->sum('total_amount');
        $totalPaid = $invoices->where('status', 'paid')->sum('total_amount');

        return view('invoices.report', compact(
            'monthlySales',
            'quarterlySales',
            'yearlySales',
            'totalRevenue',
            'totalPaid'
        ));
    }
}
