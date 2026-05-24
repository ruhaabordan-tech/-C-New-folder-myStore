<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{

public function store(StoreProductRequest $request)
{
    $category = Category::where('name', $request->category_name)->first();


    if (!$category) {
        return response()->json([
            'message' => 'عذراً، اسم القسم غير صحيح أو غير موجود.'
        ], 404);
    }

    $product = Product::create([
        'category_id' => $category->id,
        'name'        => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'quantity'    => $request->quantity,
    ]);

    return response()->json([
        'message' => 'تم إضافة المنتج بنجاح وتسكينه في قسم ' . $category->name,
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
            'message' => 'تم تحديث بيانات المنتج بنجاح',
            'data' => $product
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json([
            'message' => 'تم حذف المنتج بنجاح'
        ], 200);
    }
}
