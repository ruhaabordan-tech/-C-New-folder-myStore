<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    
    public function index()
    {
        return response()->json(Category::withCount('products')->get(), 200);
    }

    
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category, 200);
    }

    
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ], 200);
    }

    
      public function destroy(string $id)
    {

        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
        return response()->json([
            'message' => 'عذراً، لا يمكن حذف هذا القسم لأنه يحتوي على منتجات مرتبطة به. قم بنقل المنتجات أو حذفها أولاً.'
        ], 400); 
    }

    
         $category->delete();

        return response()->json([
        'message' => 'تم حذف القسم بنجاح'
         ], 200);
    }

    }