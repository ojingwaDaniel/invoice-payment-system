<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreatedMail;
use Closure;
use Illuminate\Auth\Events\Registered;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Eager load accountants to prevent N+1 queries
            $branches = Branch::where('company_id', $user->company_id)->with('accountants')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->with('accountants')->get();
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
    public function show(Branch $branch){
        return view("branches.show", compact("branch"));
    }
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
        if ($branch->is_head_office) {
            return redirect()->back()->with('error', 'The Head Office branch cannot be deleted.');
        }

        $branch->delete();

        return back()->with('success', 'Branch deleted successfully.');
    }


    public function storeAccountant(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $password = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'accountant',
            'company_id' => $branch->company_id,
            'branch_id' => $branch->id,
            'must_change_password' => true,
        ]);
        event(new Registered($user));

        // send email to accountant with credentials (Laravel Notification/Mail)
        Mail::to($user->email)->send(new AccountCreatedMail($user, $password));

        return redirect()->back()->with('success', 'Accountant created successfully!');
    }
    public function destroyAccountant(Branch $branch, User $user)
    {
        // Ensure the user is actually an accountant of this branch
        if ($user->role !== 'accountant' || $user->branch_id !== $branch->id) {
            return redirect()->back()->with('error', 'Invalid accountant');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Accountant deleted successfully.');
    }

    public function handle($request, Closure $next)
    {
        if (auth()->user()->must_change_password) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}
