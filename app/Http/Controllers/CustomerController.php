<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Restrict access to customers within same company + branch
     */
    private function authorizeCustomerAccess(Customer $customer)
    {
        $user = auth()->user();

        // Must belong to the same company
        if ($customer->company_id !== $user->company_id) {
            abort(403, 'Unauthorized: You cannot access customers from another company.');
        }

        // Admin can see all company customers
        if ($user->role === 'admin') {
            return true;
        }

        // Branch users can only see customers in their own branch
        if ($customer->branch_id !== $user->branch_id) {
            abort(403, 'Unauthorized: You cannot access customers from another branch.');
        }

        return true;
    }

    /**
     * List customers (with branch isolation)
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Customer::where('company_id', $user->company_id)
            ->withCount('invoices');

        // Branch users only see their branch
        if ($user->role !== 'admin') {
            $query->where('branch_id', $user->branch_id);
        }

        // Search functionality
        if ($request->filled('search')) {
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
            default:
                $query->orderBy('name', 'asc');
        }

        $customers = $query->paginate(15);

        // Build stats scoped to company + branch logic
        $statsQuery = Customer::where('company_id', $user->company_id);
        if ($user->role !== 'admin') {
            $statsQuery->where('branch_id', $user->branch_id);
        }

        $stats = [
            'active_customers' => $statsQuery->count(),
            'total_invoices' => Invoice::whereIn('customer_id', $statsQuery->pluck('id'))->count(),
            'new_this_month' => $statsQuery
                ->whereMonth('created_at', now()->month)
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
        $user = auth()->user();

        // Validation
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:customers,email',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string|max:500',
            'branch_id'  => $user->role === 'admin' ? 'required|exists:branches,id' : 'nullable',
        ]);

        try {
            Customer::create([
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'],
                'address'    => $validated['address'],
                'user_id'    => $user->id,
                'company_id' => $user->company_id,
                'branch_id'  => $user->role === 'admin'
                    ? $validated['branch_id']
                    : $user->branch_id,
            ]);

            return redirect()->route('customer.index')
                ->with('success', 'Customer created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create customer: ' . $e->getMessage());
        }
    }

    /**
     * Show single customer
     */
    public function show(Customer $customer)
    {
        $this->authorizeCustomerAccess($customer);

        $customer->load([
            'invoices' => function ($query) {
                $query->latest()->take(10);
            }
        ]);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show edit form
     */
    public function edit(Customer $customer)
    {
        $this->authorizeCustomerAccess($customer);
        return view('customers.form', compact('customer'));
    }

    /**
     * Update customer
     */
    public function update(Request $request, Customer $customer)
    {
        $this->authorizeCustomerAccess($customer);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $customer->id,
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        try {
            $customer->update($validated);

            return redirect()->route('customer.show', $customer)
                ->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    /**
     * Delete customer
     */
    public function destroy(Customer $customer)
    {
        $this->authorizeCustomerAccess($customer);

        try {
            $customer->delete();

            return redirect()->route('customer.index')
                ->with('success', 'Customer deleted successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete customer: ' . $e->getMessage());
        }
    }
}
