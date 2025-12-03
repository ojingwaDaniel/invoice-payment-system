<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * =========================
     *  List categories by company
     * =========================
     */
    public function index()
    {
        $companyId = auth()->user()->company_id;

        $categories = Category::where('company_id', $companyId)
            ->withCount('products')
            ->latest()
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * =========================
     *  Show create form
     * =========================
     */
    public function create()
    {
        return view('categories.form');
    }

    /**
     * =========================
     *  Store new category
     * =========================
     */
    public function store(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => "required|string|max:255|unique:categories,name,NULL,id,company_id,$companyId",
        ]);

        Category::create([
            'name' => $validated['name'],
            'company_id' => $companyId,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * =========================
     *  Show edit form
     * =========================
     */
    public function edit(Category $category)
    {
        $this->authorizeCompany($category);

        return view('categories.form', compact('category'));
    }

    /**
     * =========================
     *  Update category
     * =========================
     */
    public function update(Request $request, Category $category)
    {
        $this->authorizeCompany($category);

        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'name' =>
            "required|string|max:255|unique:categories,name,$category->id,id,company_id,$companyId",
        ]);

        $category->update($validated);

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * =========================
     *  Delete category
     * =========================
     */
    public function destroy(Category $category)
    {
        $this->authorizeCompany($category);

        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * =========================
     *  Company-based authorization
     * =========================
     */
    private function authorizeCompany(Category $category)
    {
        if ($category->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
