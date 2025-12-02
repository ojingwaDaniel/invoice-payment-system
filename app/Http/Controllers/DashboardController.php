<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Scope variables
        $companyId = $user->company_id;
        $branchId  = $user->branch_id;

        // Base query (company + branch)
        $invoiceQuery = Invoice::where('company_id', $companyId);
        $customerQuery = Customer::where('company_id', $companyId);
        $productQuery = Product::where('company_id', $companyId);

        if ($branchId) {
            $invoiceQuery->where('branch_id', $branchId);
            $customerQuery->where('branch_id', $branchId);

        }

        /** ▬▬▬ BASIC METRICS ▬▬▬ **/
        $totalInvoices = $invoiceQuery->count();
        $totalCustomers = $customerQuery->count();
        $totalProducts = $productQuery->count();

        $recentCustomers = $customerQuery->latest()->take(5)->get();

        $totalAmountDue =
            $invoiceQuery->sum('total_amount') - $invoiceQuery->sum('paid');


        /** ▬▬▬ INVOICE COLLECTION ▬▬▬ **/
        $invoices = $invoiceQuery->with('items')->get();

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


        /** ▬▬▬ SALES THIS MONTH ▬▬▬ **/
        $totalSales = $invoiceQuery->clone()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('paid');

        $lastMonthSales = $invoiceQuery->clone()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('paid');

        $salesGrowth = $lastMonthSales > 0
            ? round((($totalSales - $lastMonthSales) / $lastMonthSales) * 100, 2)
            : 0;

        $salesTarget = $lastMonthSales * 1.5;


        /** ▬▬▬ FINANCIAL METRICS ▬▬▬ **/
        $totalInvoiceIncome = $invoiceQuery->sum('paid');
        $paidInvoices = $invoiceQuery->where('status', 'paid')->count();

        $avgInvoiceAmount = $totalInvoices > 0
            ? $invoiceQuery->avg('total_amount')
            : 0;


        /** ▬▬▬ RECENT INVOICES ▬▬▬ **/
        $recentInvoices = $invoiceQuery->with('customer')->latest()->take(5)->get();


        /** ▬▬▬ RECENT TRANSACTIONS ▬▬▬ **/
        $recentTransactions = $invoiceQuery
            ->whereNotNull('paid')
            ->where('paid', '>', 0)
            ->with('customer')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->groupBy(function ($invoice) {
                $date = $invoice->updated_at;

                if ($date->isToday()) {
                    return 'Today';
                } elseif ($date->isYesterday()) {
                    return 'Yesterday';
                }
                return $date->format('M d, Y');
            });


        /** ▬▬▬ TOP CUSTOMERS ▬▬▬ **/
        $topCustomers = $customerQuery
            ->withSum('invoices', 'paid')
            ->withCount('invoices')
            ->orderByDesc('invoices_sum_paid')
            ->take(5)
            ->get();


        /** ▬▬▬ SALES ACTIVITY COUNT ▬▬▬ **/
        $totalSalesCount = $invoiceQuery->clone()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthSalesCount = $invoiceQuery->clone()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $salesGrowthCount = $lastMonthSalesCount > 0
            ? round((($totalSalesCount - $lastMonthSalesCount) / $lastMonthSalesCount) * 100, 2)
            : 0;


        /** ▬▬▬ UNSENT INVOICES ▬▬▬ **/
        $pendingInvoices = $invoiceQuery->where('is_sent', false)->count();


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
            'topCustomers',
            'totalSalesCount',
            'salesGrowthCount',
            'pendingInvoices'
        ));
    }
}
