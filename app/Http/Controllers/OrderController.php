<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    
    public function show(string $id)
    {
        $order = Order::findOrFail($id);

        return response()->json($order, 200);
    }

    
    public function update(UpdateOrderRequest $request, string $id)
    {
        $order = Order::findOrFail($id);

        $order->update($request->validated());

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ], 200);
    }
}