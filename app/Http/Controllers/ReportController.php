<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DailyExpense;
use App\Models\Product;
use Illuminate\Http\Request;


class ReportController extends Controller
{


public function dailyProfit(Request $request)
{
    
    $date = $request->query('date', today()->format('Y-m-d'));

    
    $sales = Order::where('status', 'completed')
                  ->whereDate('created_at', $date)
                  ->sum('total_price');

    
    $expenses = DailyExpense::whereDate('entry_date', $date)
                            ->sum('amount');

    
    $profit = $sales - $expenses;

    
     $lowStockProducts = Product::where('quantity', '<', 5)
                               ->get(['name', 'quantity']);

    return response()->json([
        'report_date'      => $date,
        'sales'            => $sales,
        'expenses'         => $expenses,
        'net_profit'       => $profit,
        'low_stock_alerts' => $lowStockProducts,
    ], 200);
}



public function monthlyReport()
{
    
    $start = now()->startOfMonth();
    $end = now()->endOfMonth();

    
    $sales = Order::where('status', 'completed')
                  ->whereBetween('created_at', [$start, $end])
                  ->sum('total_price');

    
    $expenses = DailyExpense::whereBetween('entry_date', [$start, $end])
                            ->sum('amount');

    
    $lowStockProducts = Product::where('quantity', '<', 5)
                               ->get(['name', 'quantity']);

    return response()->json([
        'month_name'     => now()->format('F Y'),
        'monthly_sales'  => $sales,
        'monthly_expenses' => $expenses,
        'net_profit'     => $sales - $expenses,
        'low_stock_details' => $lowStockProducts, 
    ], 200);
}



public function lowStockReport()
{
    
    $products = Product::where('quantity', '<', 5)
                       ->orderBy('quantity', 'asc') 
                       ->get(['name', 'quantity']);

    
    if ($products->isEmpty()) {
        return response()->json([
            'message' => 'جميع المنتجات متوفرة بكميات جيدة',
            'data' => []
        ], 200);
    }

    return response()->json([
        'message' => 'تنبيه: هناك منتجات أوشكت على النفاذ',
        'count' => $products->count(),
        'products' => $products
    ], 200);
}



public function inventoryValue()
{
    
    $totalValue = Product::all()->sum(function($product) {
        return $product->quantity * $product->price;
    });

    return response()->json([
        'report_type' => 'إجمالي قيمة المخزون',
        'inventory_total_value' => number_format($totalValue, 0, '.', ','), 
        'currency' => 'ل.س',
        'message' => 'هذه القيمة تمثل إجمالي سعر بيع البضاعة المتوفرة حالياً في المستودع'
    ], 200);
}


public function topSelling()
{

    $topProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_qty')
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')
        ->take(5)
        ->with('product:id,name,price')
        ->get();

    return response()->json([
        'report_type' => 'الأكثر مبيعاً',
        'top_selling_products' => $topProducts,
        'currency' => 'ل.س'
    ], 200);
}



}