<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    
    public function index(Request $request)
{
    // Get sorting parameters, defaulting to name and ascending order
    $sortField = $request->get('sort', 'name');
    $sortDirection = $request->get('direction', 'asc');

    // Get search parameters
    $searchQuery = $request->get('search', '');

    // Build the query with sorting and search
    $products = Product::query()
        ->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('product_id', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
        })
        ->orderBy($sortField, $sortDirection)
        ->paginate(10)
        ->appends(['sort' => $sortField, 'direction' => $sortDirection, 'search' => $searchQuery]);

    return view('products.index', compact('products', 'sortField', 'sortDirection', 'searchQuery'));
}


    
    public function create()
    {
        return view('products.create');
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|string',
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|unique:products,product_id,' . $id,
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

