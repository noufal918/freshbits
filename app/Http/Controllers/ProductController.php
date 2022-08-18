<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Products list
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    // Store Product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'upc' => 'required|string|unique:products,upc',
            'image' => 'required|max:2048|image|mimes:jpg,png,jpeg,gif,svg'
        ]);

        $product = new Product;
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->upc = $validated['upc'];

        if ($request->file('image')) {
            $path =  $request->file('image')->storeAs(
                'uploads/products/image',
                urlencode(time()) . '_' . uniqid() . '_' . $request->image->getClientOriginalName(),
                'public'
            );
            $product->image = $path;
        }

        $res = $product->save();
        if ($res) {
            return back()->with('success', 'Product created successfully.');
        } else {
            return back()->with('error', 'Failed to Create. Please try again');
        }
        return redirect()->back();
    }

    // Show Product
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Edit Product
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update Product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'upc' => 'required|string|unique:products,upc,' . $product->id,
            'image' => 'max:2048|image|mimes:jpg,png,jpeg,gif,svg'
        ]);

        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->upc = $validated['upc'];

        if ($request->file('image')) {
            $path =  $request->file('image')->storeAs(
                'uploads/products/image',
                urlencode(time()) . '_' . uniqid() . '_' . $request->image->getClientOriginalName(),
                'public'
            );
            $product->image = $path;
        }

        $res = $product->save();
        if ($res) {
            return back()->with('success', 'Product updated successfully.');
        } else {
            return back()->with('error', 'Failed to Update. Please try again');
        }
        return redirect()->back();
    }

    // Delete Product
    public function destroy(Product $product)
    {
        $res = $product->delete();

        if ($res) {
            return back()->with('success', 'Product deleted successfully.');
        } else {
            return back()->with('error', 'Failed to Delete. Please try again');
        }
        return redirect()->back();
    }

    // Change Product Status
    public function changeStatus(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => 'Status change successfully.']);
    }
}
