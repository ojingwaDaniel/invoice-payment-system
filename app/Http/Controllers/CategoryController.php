<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $companyId = auth()->id();

        $categories = Category::where('user_id', $companyId)
            ->withCount('products')
            ->latest()
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . auth()->id(),
        ]);

        Category::create([
            'name' => $validated['name'],
            'user_id' => auth()->id(), // ✅ FIXED: must match migration
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }


    public function edit(Category $category)
    {
        $this->authorizeAccess($category);
        return view('categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeAccess($category);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . ',id,user_id,' . auth()->id(),
        ]);

        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->authorizeAccess($category);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }

    private function authorizeAccess(Category $category)
    {
        if ($category->user->id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
