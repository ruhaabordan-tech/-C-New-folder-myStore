<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
class OrderController extends Controller
{

public function index()
{
    
    $orders = Order::with(['admin', 'orderItems.product'])->latest()->get();
    
    return response()->json([
        'count' => $orders->count(),
        'orders' => $orders
    ], 200);
}

    
public function store(StoreOrderRequest $request)
{
    return DB::transaction(function () use ($request) {
        $order = Order::create([
            'admin_id'    => $request->admin_id,
            'total_price' => $request->total_price,
            'status'      => $request->status,
        ]);

        
        foreach ($request->items as $item) {
            $product = \App\Models\Product::findOrFail($item['product_id']);

            
            if ($product->quantity < $item['quantity']) {
                throw new \Exception("الكمية غير كافية للمنتج: {$product->name}");
            }

            
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $product->price, 
            ]);

            
            $product->decrement('quantity', $item['quantity']);
        }

        return response()->json(['message' => 'تم تسجيل المبيع بنجاح وتحديث المخزن'], 201);
    });
}



    
  public function show(string $id)
{
    
    $order = Order::with(['admin', 'orderItems.product'])->findOrFail($id);

    return response()->json($order, 200);
}


    
    public function update(UpdateOrderRequest $request, string $id)
    {
        $order = Order::findOrFail($id);

        $order->update($request->validated());

        return response()->json([
            'message' => 'تم تحديث بيانات الطلب بنجاح',
            'data' => $order
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return response()->json([
            'message' => 'تم حذف المنتج بنجاح'
        ], 200);
    }
}
