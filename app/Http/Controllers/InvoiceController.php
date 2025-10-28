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
use App\Mail\InvoiceMail;

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
    /** ======================
     *  Store new invoice
     *  ====================== */
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
            'items.*.tax_percent' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $userId = auth()->id();
            $items = $validated['items'];
            $subtotal = 0;

            foreach ($items as &$item) {
                $qty = (float) ($item['quantity'] ?? 0);
                $rate = (float) ($item['rate'] ?? 0);
                $discount = (float) ($item['discount'] ?? 0);
                $taxPercent = (float) ($item['tax_percent'] ?? 0);

                $base = $qty * $rate;
                $afterDiscount = $base - $discount;
                $taxAmount = ($taxPercent / 100) * $afterDiscount;
                $item['amount'] = round($afterDiscount + $taxAmount, 2);
                $subtotal += $item['amount'];
            }

            $globalDiscount = (float) ($validated['discount'] ?? 0);
            $total = max(0, $subtotal - $globalDiscount);

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
                'status' => 'unpaid',
            ]);

            foreach ($items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? '',
                    'rate' => $item['rate'],
                    'discount' => $item['discount'] ?? 0,
                    'tax_percent' => $item['tax_percent'] ?? 0,
                    'amount' => $item['amount'],
                ]);
            }

            DB::commit();
            return redirect()->route('invoice.index')->with('success', 'Invoice created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }
    /** ======================
     *  Edit existing invoice
     *  ====================== */
    public function edit(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load('items');

        $userId = auth()->id();
        $products = Product::where('user_id', $userId)->orderBy('name')->get();
        $customers = Customer::where('user_id', $userId)->orderBy('name')->get();

        return view('invoices.form', compact('invoice', 'products', 'customers'));
    }


    /** ======================
     *  Update invoice
     *  ====================== */
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
            'items.*.tax_percent' => 'nullable|numeric|min:0',
            'items.*.amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Recalculate total
            $items = $validated['items'];
            $subtotal = 0;

            foreach ($items as &$item) {
                $rate = (float)($item['rate'] ?? 0);
                $qty = (float)($item['quantity'] ?? 0);
                $discount = (float)($item['discount'] ?? 0);
                $tax_percent = (float)($item['tax_percent'] ?? 0);

                $base = $rate * $qty;
                $afterDiscount = $base - $discount;
                $tax = ($tax_percent / 100) * $afterDiscount;
                $item['amount'] = round($afterDiscount + $tax, 2);

                $subtotal += $item['amount'];
            }

            $globalDiscount = (float)($validated['discount'] ?? 0);
            $total = max(0, $subtotal - $globalDiscount);

            // Update invoice
            $invoice->update([
                'customer_id' => $validated['customer_id'],
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'] ?? null,
                'currency' => $validated['currency'],
                'notes' => $validated['notes'] ?? null,
                'discount' => $globalDiscount,
                'total_amount' => $total,
            ]);

            // Remove old items then recreate
            $invoice->items()->delete();
            foreach ($items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? '',
                    'rate' => $item['rate'],
                    'discount' => $item['discount'] ?? 0,
                    'tax_percent' => $item['tax_percent'] ?? 0,
                    'amount' => $item['amount'],
                ]);
            }

            DB::commit();
            return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update invoice: ' . $e->getMessage()]);
        }
    }

    /** ======================
     *  Show single invoice
     *  ====================== */
    public function show(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);
        $invoice->load('items', 'customer');
        return view('invoices.show', compact('invoice'));
    }
    public function download(Invoice $invoice)
    {
        // Load relationships
        $invoice->load(['customer', 'items', 'user']);

        // Calculate totals
        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(function ($item) {
            return ($item->quantity * $item->rate * $item->tax_percent) / 100;
        });

        // Generate PDF
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Download with filename
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    // Alternative: Stream PDF in browser instead of download
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

        // Stream (view in browser)
        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function send(Invoice $invoice)
    {
        // Check if customer has email
        if (!$invoice->customer->email) {
            return redirect()->back()->with('error', 'Customer does not have an email address.');
        }

        // Load relationships
        $invoice->load(['customer', 'items', 'user']);

        // Calculate totals
        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(function ($item) {
            return ($item->quantity * $item->rate * $item->tax_percent) / 100;
        });

        // Generate PDF
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
        ]);

        // Send email with PDF attachment
        try {
            Mail::to($invoice->customer->email)
                ->send(new InvoiceMail($invoice, $pdf->output()));

            // Optional: Log the email sent
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


    /** ======================
     *  Delete invoice
     *  ====================== */
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
}
