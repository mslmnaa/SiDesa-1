<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Models\Infaq\Infaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        $recentProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $popularProducts = Product::with('category')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $categoryStats = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();
        
        $activeProducts = Product::where('status', 'active')->count();
        $inactiveProducts = Product::where('status', 'inactive')->count();
        
        // Infaq Statistics
        $infaqStats = [
            'total_pending' => Infaq::where('status', 'pending')->count(),
            'total_verified' => Infaq::where('status', 'verified')->count(),
            'total_completed' => Infaq::where('status', 'completed')->count(),
            'total_amount_collected' => Infaq::whereIn('status', ['verified', 'completed'])->sum('amount'),
            'total_donors' => Infaq::whereIn('status', ['verified', 'completed'])->count(),
            'monthly_infaq' => Infaq::whereIn('status', ['verified', 'completed'])
                ->where('created_at', '>=', now()->subMonths(6))
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('SUM(amount) as total')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get()
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalCategories',
            'recentProducts',
            'popularProducts',
            'categoryStats',
            'activeProducts',
            'inactiveProducts',
            'infaqStats'
        ));
    }
}
