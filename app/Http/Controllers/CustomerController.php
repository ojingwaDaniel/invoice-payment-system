<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display all customers
     */
    public function index(Request $request)
    {
        $query = Customer::withCount('invoices');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            default: // 'name'
                $query->orderBy('name', 'asc');
        }

        $customers = $query->paginate(15);

        // Calculate statistics
        $stats = [
            'active_customers' => Customer::count(),
            'total_invoices' => DB::table('invoices')->count(),
            'new_this_month' => Customer::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('customers.index', compact('customers', 'stats'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('customers.form');
    }

    /**
     * Store new customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        try {
            $validated['user_id'] = auth()->id(); // 👈 add current logged in user
            Customer::create($validated);

            return redirect()->route('customer.index')->with('success', 'Customer created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create customer: ' . $e->getMessage());
        }
    }


    /**
     * Show single customer
     */
    public function show(Customer $customer)
    {
        $customer->load(['invoices' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show edit form
     */
    public function edit(Customer $customer)
    {
        return view('customers.form', compact('customer'));
    }

    /**
     * Update customer
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        try {
            $customer->update($validated);
            return redirect()->route('customer.show', $customer)->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    /**
     * Delete customer
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('customer.index')->with('success', 'Customer deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete customer: ' . $e->getMessage());
        }
    }
}
