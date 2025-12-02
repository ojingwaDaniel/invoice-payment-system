<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Company admin sees all branches in the company
        if ($user->role === 'admin') {
            $branches = Branch::where('company_id', $user->company_id)->get();
        } else {
            // Other roles see only their own branch
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        return view("branches.index", compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("branches.form");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'manager' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        Branch::create([
            'company_id' => $user->company_id,
            'name' => $request->name,
            'manager' => $request->manager,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('branch.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();

        $branch = Branch::where('company_id', $user->company_id)
            ->where('id', $id)
            ->firstOrFail();

        return view("branches.form", compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        $branch = Branch::where('company_id', $user->company_id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'manager' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $branch->update([
            'name' => $request->name,
            'manager' => $request->manager,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('branch.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();

        $branch = Branch::where('company_id', $user->company_id)
            ->where('id', $id)
            ->firstOrFail();

        $branch->delete();

        return back()->with('success', 'Branch deleted successfully.');
    }
}
