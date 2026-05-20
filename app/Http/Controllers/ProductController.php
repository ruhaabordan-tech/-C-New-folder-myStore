<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product, 200);
    }

    
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
