<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * =========================
     *  List products by company
     * =========================
     */
    public function index()
    {
        $companyId = auth()->user()->company_id;

        $products = Product::where('company_id', $companyId)
            ->latest()
            ->paginate(20);

        $units = Unit::where('company_id', $companyId)
            ->orderBy('name')
            ->get();

        return view('products.index', compact('products', 'units'));
    }

    /**
     * =========================
     *  Show create form
     * =========================
     */
    public function create()
    {
        $companyId = auth()->user()->company_id;

        $categories = Category::where('company_id', $companyId)->get();
        $units = Unit::where('company_id', $companyId)->orderBy('name')->get();

        return view('products.form', compact('categories', 'units'));
    }

    /**
     * =========================
     *  Show edit form
     * =========================
     */
    public function edit(Product $product)
    {
        $this->authorizeCompany($product);

        $companyId = auth()->user()->company_id;

        $categories = Category::where('company_id', $companyId)->get();
        $units = Unit::where('company_id', $companyId)->orderBy('name')->get();

        return view('products.form', compact('product', 'categories', 'units'));
    }

    /**
     * =========================
     *  Store new product
     * =========================
     */
    public function store(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'selling_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'type' => 'required|in:product,service',
            'description' => 'nullable|string',
        ]);

        $validated['company_id'] = $companyId;

        // Save category name too
        $category = Category::find($request->category_id);
        $validated['category'] = $category?->name;

        // Generate product code
        $prefix = $validated['type'] === 'service' ? 'S' : 'P';

        $lastProduct = Product::where('company_id', $companyId)
            ->where('type', $validated['type'])
            ->latest('id')
            ->first();

        $nextNumber = $lastProduct
            ? ((int) filter_var($lastProduct->code, FILTER_SANITIZE_NUMBER_INT) + 1)
            : 1;

        $validated['code'] = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Product::create($validated);

        return redirect()->route('product.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * =========================
     *  Update product
     * =========================
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeCompany($product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'selling_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'type' => 'required|in:product,service',
            'description' => 'nullable|string',
        ]);

        // Apply category name
        $category = Category::find($request->category_id);
        $validated['category'] = $category?->name;

        $product->update($validated);

        return redirect()->route('product.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * =========================
     *  Delete product
     * =========================
     */
    public function destroy(Product $product)
    {
        $this->authorizeCompany($product);

        $product->delete();

        return redirect()->route('product.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * =========================
     *  Company-based authorization
     * =========================
     */
    private function authorizeCompany(Product $product)
    {
        if ($product->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
