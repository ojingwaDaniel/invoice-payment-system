<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Basic Metrics
        $totalInvoices = Invoice::where('user_id', $user->id)->count();
        $totalProducts = Product::where('user_id', $user->id)->count();
        $totalCustomers = Customer::where('user_id', $user->id)->count();
        $recentCustomers = Customer::where('user_id', $user->id)->latest()->take(5)->get();

        $totalAmountDue = Invoice::where('user_id', $user->id)
            ->sum('total_amount') - Invoice::where('user_id', $user->id)->sum('paid');

        $invoices = $user->invoices;

        // Invoice Statistics
        $invoiced = $invoices->sum(function ($invoice) {
            $subtotal = $invoice->items->sum('amount');
            $discount = $invoice->discount ?? 0;
            $vat = $invoice->vat_amount ?? 0;
            return ($subtotal - $discount) + $vat;
        });

        $received = $invoices->sum('paid');
        $outstanding = $invoiced - $received;

        $overdue = $invoices->where('due_date', '<', now())
            ->where('status', '!=', 'paid')
            ->sum(function ($invoice) {
                $subtotal = $invoice->items->sum('amount');
                $discount = $invoice->discount ?? 0;
                $vat = $invoice->vat_amount ?? 0;
                $total = ($subtotal - $discount) + $vat;
                return $total - $invoice->paid;
            });

        // Total Sales (This month)
        $totalSales = Invoice::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('paid');

        // Sales Growth (Compare with last month)
        $lastMonthSales = Invoice::where('user_id', $user->id)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('paid');

        $salesGrowth = $lastMonthSales > 0
            ? round((($totalSales - $lastMonthSales) / $lastMonthSales) * 100, 2)
            : 0;

        // Sales Target (Example: set to 150% of last month or a fixed amount)
        $salesTarget = $lastMonthSales * 1.5;

        // Total Invoice Income (All time paid)
        $totalInvoiceIncome = Invoice::where('user_id', $user->id)->sum('paid');

        // Paid Invoices Count
        $paidInvoices = Invoice::where('user_id', $user->id)
            ->where('status', 'paid')
            ->count();

        // Average Invoice Amount
        $avgInvoiceAmount = $totalInvoices > 0
            ? Invoice::where('user_id', $user->id)->avg('total_amount')
            : 0;

        // Recent Invoices (Last 5)
        $recentInvoices = Invoice::where('user_id', $user->id)
            ->with('customer')
            ->latest()
            ->take(5)
            ->get();

    
        $recentTransactions = Invoice::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($invoice) {
                return (object) [
                    'description' => 'Invoice Payment - ' . $invoice->invoice_number,
                    'amount' => $invoice->paid,
                    'type' => $invoice->paid > 0 ? 'credit' : 'debit',
                    'created_at' => $invoice->created_at
                ];
            });
        $topCustomers = Customer::where('user_id', $user->id)
            ->withSum('invoices', 'paid')  
            ->withCount('invoices')
            ->orderByDesc('invoices_sum_paid')
            ->take(5)
            ->get();


        return view('admin.index', compact(
            'totalInvoices',
            'totalCustomers',
            'totalAmountDue',
            'totalProducts',
            'invoiced',
            'received',
            'outstanding',
            'overdue',
            'totalSales',
            'salesGrowth',
            'salesTarget',
            'totalInvoiceIncome',
            'paidInvoices',
            'avgInvoiceAmount',
            'recentInvoices',
            'recentTransactions',
            'recentCustomers',
            'topCustomers'
        ));
    }
}
