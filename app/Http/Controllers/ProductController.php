<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /** =========================
     *  List all products (user-specific)
     *  ========================= */
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->latest()->paginate(20);
        return view('products.index', compact('products'));
    }

    /** =========================
     *  Show create form
     *  ========================= */
    public function create()
    {
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    /** =========================
     *  Show edit form
     *  ========================= */
    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
        $categories = Category::all();
        return view('products.form', compact('product',"categories"));
    }

    /** =========================
     *  Store new product
     *  ========================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'type' => 'required|in:product,service',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        // ✅ Auto-generate unique product code
        $prefix = $validated['type'] === 'service' ? 'S' : 'P';
        $lastProduct = Product::where('user_id', auth()->id())
            ->where('type', $validated['type'])
            ->latest('id')
            ->first();

        $nextNumber = $lastProduct
            ? ((int) filter_var($lastProduct->code, FILTER_SANITIZE_NUMBER_INT) + 1)
            : 1;

        $validated['code'] = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // ✅ Create product
        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }


    /** =========================
     *  Update product
     *  ========================= */
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,' . $product->id,
            'category' => 'nullable|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'type' => 'required|in:product,service',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);
        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }

    /** =========================
     *  Prevent unauthorized access
     *  ========================= */
    private function authorizeUser(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
