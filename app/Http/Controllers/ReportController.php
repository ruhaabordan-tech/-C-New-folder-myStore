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


public function monthlyReport(Request $request)
{
    $month = $request->query('month', now()->month);
    $year = $request->query('year', now()->year);

    
    $targetDate = \Carbon\Carbon::createFromDate($year, $month, 1);
    $start = $targetDate->copy()->startOfMonth();
    $end = $targetDate->copy()->endOfMonth();

    
    $sales = Order::where('status', 'completed')
                  ->whereBetween('created_at', [$start, $end])
                  ->sum('total_price');

    $expenses = DailyExpense::whereBetween('entry_date', [$start, $end])
                            ->sum('amount');

    $lowStockProducts = Product::where('quantity', '<', 5)
                               ->get(['name', 'quantity']);

    return response()->json([
        'report_for'        => $targetDate->format('F Y'), 
        'monthly_sales'     => $sales,
        'monthly_expenses'  => $expenses,
        'net_profit'        => $sales - $expenses,
        'low_stock_details' => $lowStockProducts, 
    ], 200);
}




public function lowStockReport()
{
    
    $products = Product::whereRaw('quantity < min_quantity_alert')
                   ->orderBy('quantity', 'asc') 
                   ->get(['name', 'quantity', 'min_quantity_alert']);
    
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
        ->with('product:id,name') 
        ->get()
        ->map(function ($item) {
            return [
                'product_name' => $item->product->name ?? 'منتج محذوف',
                'units_sold'   => (int) $item->total_qty,
            ];
        });

    return response()->json([
        'report_type' => 'قائمة الأكثر مبيعاً',
        'data'        => $topProducts
    ], 200);
}




}