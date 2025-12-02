<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;

        $units = Unit::where('company_id', $companyId)
            ->latest()
            ->get();

        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.form');
    }

    public function store(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name,NULL,id,company_id,' . $companyId,
            'short_name' => 'nullable|string|max:255',
        ]);

        Unit::create([
            'name' => $validated['name'],
            'short_name' => $validated['short_name'] ?? null,
            'company_id' => $companyId,
        ]);

        return redirect()->route('unit.index')
            ->with('success', 'Unit created successfully');
    }


    public function edit(Unit $unit)
    {
        $this->authorizeUnit($unit);

        return view('units.form', compact('unit'));
    }


    public function update(Request $request, Unit $unit)
    {
        $this->authorizeUnit($unit);

        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $unit->id . ',id,company_id,' . $companyId,
            'short_name' => 'nullable|string|max:255',
        ]);

        $unit->update($validated);

        return redirect()->route('unit.index')
            ->with('success', 'Unit updated successfully');
    }


    public function destroy(Unit $unit)
    {
        $this->authorizeUnit($unit);

        $unit->delete();

        return redirect()->route('unit.index')
            ->with('success', 'Unit deleted successfully');
    }


    private function authorizeUnit(Unit $unit)
    {
        if ($unit->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized access');
        }
    }
}
