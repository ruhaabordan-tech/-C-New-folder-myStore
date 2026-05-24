<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;

class OrderItemController extends Controller
{
    
    public function index()
    {
    $items = OrderItem::with(['product:name', 'order:status'])->get();
    $items->makeHidden(['product_id', 'order_id']);
    return response()->json($items, 200);
    }

    
    public function store(StoreOrderItemRequest $request)
    {
        $orderItem = OrderItem::create($request->validated());

        return response()->json([
            'message' => 'تم إضافة الصنف إلى الطلب بنجاح',
            'data' => $orderItem
        ], 201);
    }

    
    public function show(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        return response()->json($orderItem, 200);
    }

    
    public function update(UpdateOrderItemRequest $request, string $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $orderItem->update($request->validated());

        return response()->json([
            'message' => 'تم تحديث بيانات الصنف بنجاح',
            'data' => $orderItem
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $orderItem->delete();

        return response()->json([
            'message' => 'تم إزالة المنتج من الفاتورة بنجاح'
        ], 200);
    }
}