<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        
        // Monthly Revenue (last 6 months)
        $monthlyRevenue = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Recent Orders
        $recentOrders = Order::with('user', 'orderItems.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Top Products (by quantity sold)
        $topProducts = Product::select(
                'products.id',
                'products.name', 
                'products.price',
                'products.stock',
                'products.images',
                'products.category_id',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy(
                'products.id',
                'products.name',
                'products.price', 
                'products.stock',
                'products.images',
                'products.category_id'
            )
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        // Low Stock Products (stock <= 10)
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('status', 'active')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
        
        // Orders by Status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts', 
            'totalOrders',
            'totalRevenue',
            'monthlyRevenue',
            'recentOrders',
            'topProducts',
            'lowStockProducts',
            'ordersByStatus'
        ));
    }
}
