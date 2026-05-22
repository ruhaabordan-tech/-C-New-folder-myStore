<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
  public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    
   public function index(Request $request)
{
    $query = Product::with('category');

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->has('low_stock')) {
        $query->where('quantity', '<', 5);
    }

    return response()->json($query->get(), 200);
}


    

       public function show(string $id)
         {
             $product = Product::with('category')->findOrFail($id);
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
