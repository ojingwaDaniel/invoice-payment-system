<?php

namespace App\Http\Controllers;
use \App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view("products.index",compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    public function edit(Product $product)
    {
    
        $categories = Category::all();
        return view('products.form', compact('product', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ 1. Validate the incoming request
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|string|max:255',
            'category'       => 'required|string|max:255',
            'selling_price'  => 'required|integer|min:0',
            'purchase_price' => 'required|integer|min:0',
            'quantity'       => 'required|integer|min:0',
            'unit'           => 'required|string|max:50',
            'type'           => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // ✅ 2. Handle image upload (if any)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // ✅ 3. Create the product
        Product::create($validated);

        // ✅ 4. Redirect with a success message
        return redirect()
            ->route('product.index')
            ->with('success', 'Product created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,service',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:products,code,' . $product->id,
            'category' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'selling_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('product.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
