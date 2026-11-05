<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Models\Village;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Check if admin village has set shipping origin location
        $needsShippingSetup = false;
        if ($user->isAdmin() && $user->village_id) {
            $village = Village::find($user->village_id);
            $needsShippingSetup = !$village || empty($village->origin_city_id);
        }

        // Basic Statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalVillages = Village::where('status', 'active')->count();
        $totalCategories = Category::count();

        // Admin hanya lihat produk desanya, SuperAdmin lihat semua
        $productsQuery = Product::query();
        if ($user->isAdmin() && $user->village_id) {
            $productsQuery->where('village_id', $user->village_id);
        }

        $totalProducts = $productsQuery->count();
        $activeProducts = (clone $productsQuery)->where('status', 'active')->count();
        $inactiveProducts = (clone $productsQuery)->where('status', 'inactive')->count();
        $lowStockProducts = (clone $productsQuery)->where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = (clone $productsQuery)->where('stock', 0)->count();

        // Recent Products
        $recentProducts = (clone $productsQuery)
            ->with(['category', 'village'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Top Villages by Product Count (SuperAdmin only)
        $topVillages = null;
        if ($user->isSuperAdmin()) {
            $topVillages = Village::withCount('products')
                ->where('status', 'active')
                ->orderBy('products_count', 'desc')
                ->take(5)
                ->get();
        }

        // Category Statistics
        $categoryStats = Category::withCount(['products' => function($query) use ($user) {
            if ($user->isAdmin() && $user->village_id) {
                $query->where('village_id', $user->village_id);
            }
        }])
        ->orderBy('products_count', 'desc')
        ->take(6)
        ->get();

        // Orders Statistics (if user's village or all for superadmin)
        $ordersQuery = Order::query();
        if ($user->isAdmin() && $user->village_id) {
            $ordersQuery->whereHas('items', function($query) use ($user) {
                $query->where('village_id', $user->village_id);
            });
        }

        $totalOrders = $ordersQuery->count();
        $pendingOrders = (clone $ordersQuery)->where('status', 'pending')->count();
        $completedOrders = (clone $ordersQuery)->where('status', 'completed')->count();

        // Revenue (if needed)
        $totalRevenue = (clone $ordersQuery)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Product Type Distribution
        $productsByType = [
            'barang' => (clone $productsQuery)->where('type', 'barang')->count(),
            'jasa' => (clone $productsQuery)->where('type', 'jasa')->count(),
        ];

        // ===== Dashboard v2: ringkasan bulanan, grafik, terlaris, pesanan terbaru =====
        $villageId = ($user->isAdmin() && $user->village_id) ? $user->village_id : null;
        $now = Carbon::now();
        $thisMonthStart = $now->copy()->startOfMonth();
        $lastMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = $thisMonthStart->copy()->subSecond();

        // Pendapatan dihitung dari item pesanan yang sudah dibayar (per desa untuk admin desa)
        $paidItems = function () use ($villageId) {
            $q = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.payment_status', 'paid')
                ->where('orders.status', '!=', 'cancelled');
            if ($villageId) {
                $q->where('order_items.village_id', $villageId);
            }
            return $q;
        };
        $paidDate = DB::raw('COALESCE(orders.paid_at, orders.created_at)');

        $revenueThisMonth = (float) $paidItems()->whereBetween($paidDate, [$thisMonthStart, $now])->sum('order_items.subtotal');
        $revenueLastMonth = (float) $paidItems()->whereBetween($paidDate, [$lastMonthStart, $lastMonthEnd])->sum('order_items.subtotal');

        $ordersThisMonth = (clone $ordersQuery)->whereBetween('created_at', [$thisMonthStart, $now])->count();
        $ordersLastMonth = (clone $ordersQuery)->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

        $activeOrders = (clone $ordersQuery)->whereIn('status', ['pending', 'processing', 'shipped'])->count();

        $cancelScope = function ($q) {
            $q->where('status', 'cancelled')->orWhere('payment_status', 'refunded');
        };
        $cancelThisMonth = (clone $ordersQuery)->where($cancelScope)->whereBetween('updated_at', [$thisMonthStart, $now])->count();
        $cancelLastMonth = (clone $ordersQuery)->where($cancelScope)->whereBetween('updated_at', [$lastMonthStart, $lastMonthEnd])->count();

        $growth = function ($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? null : 0.0; // null = belum ada data bulan lalu
            }
            return round((($current - $previous) / $previous) * 100, 1);
        };

        $lastMonthLabel = $lastMonthStart->locale('id')->translatedFormat('F Y');

        $summaryCards = [
            [
                'label' => 'Pendapatan Bulan Ini',
                'value' => 'Rp' . number_format($revenueThisMonth, 0, ',', '.'),
                'growth' => $growth($revenueThisMonth, $revenueLastMonth),
                'up_is_good' => true,
                'note' => 'dibandingkan ' . $lastMonthLabel,
                'icon' => 'cash',
                'link' => route('admin.orders.index', ['payment_status' => 'paid']),
            ],
            [
                'label' => 'Pesanan Bulan Ini',
                'value' => number_format($ordersThisMonth, 0, ',', '.'),
                'growth' => $growth($ordersThisMonth, $ordersLastMonth),
                'up_is_good' => true,
                'note' => 'dibandingkan ' . $lastMonthLabel,
                'icon' => 'cart',
                'link' => route('admin.orders.index'),
            ],
            [
                'label' => 'Pesanan Aktif',
                'value' => number_format($activeOrders, 0, ',', '.'),
                'growth' => false, // snapshot, tanpa perbandingan
                'up_is_good' => true,
                'note' => $pendingOrders . ' menunggu diproses',
                'icon' => 'truck',
                'link' => route('admin.orders.index', ['status' => 'pending']),
            ],
            [
                'label' => 'Batal / Refund',
                'value' => number_format($cancelThisMonth, 0, ',', '.'),
                'growth' => $growth($cancelThisMonth, $cancelLastMonth),
                'up_is_good' => false,
                'note' => 'dibandingkan ' . $lastMonthLabel,
                'icon' => 'return',
                'link' => route('admin.orders.index', ['status' => 'cancelled']),
            ],
        ];

        // Grafik penjualan: Mingguan (8 minggu), Bulanan (6 bulan), Tahunan (5 tahun)
        $buildSeries = function (string $period) use ($paidItems, $paidDate, $now) {
            $points = [];
            if ($period === 'weekly') {
                for ($i = 7; $i >= 0; $i--) {
                    $start = $now->copy()->startOfWeek()->subWeeks($i);
                    $end = $start->copy()->endOfWeek();
                    $points[] = [
                        'label' => $start->format('d/m'),
                        'full' => 'Minggu ' . $start->locale('id')->translatedFormat('d M') . ' – ' . $end->locale('id')->translatedFormat('d M Y'),
                        'value' => (float) $paidItems()->whereBetween($paidDate, [$start, $end])->sum('order_items.subtotal'),
                    ];
                }
            } elseif ($period === 'yearly') {
                for ($i = 4; $i >= 0; $i--) {
                    $start = $now->copy()->startOfYear()->subYears($i);
                    $points[] = [
                        'label' => $start->format('Y'),
                        'full' => 'Tahun ' . $start->format('Y'),
                        'value' => (float) $paidItems()->whereBetween($paidDate, [$start, $start->copy()->endOfYear()])->sum('order_items.subtotal'),
                    ];
                }
            } else {
                for ($i = 5; $i >= 0; $i--) {
                    $start = $now->copy()->startOfMonth()->subMonthsNoOverflow($i);
                    $points[] = [
                        'label' => $start->locale('id')->translatedFormat('F'),
                        'short' => $start->locale('id')->translatedFormat('M'),
                        'full' => $start->locale('id')->translatedFormat('F Y'),
                        'value' => (float) $paidItems()->whereBetween($paidDate, [$start, $start->copy()->endOfMonth()])->sum('order_items.subtotal'),
                    ];
                }
            }
            return $points;
        };
        $salesChart = [
            'weekly' => $buildSeries('weekly'),
            'monthly' => $buildSeries('monthly'),
            'yearly' => $buildSeries('yearly'),
        ];

        // Produk terlaris (berdasarkan jumlah terjual dari pesanan yang dibayar)
        $bestSellerRows = $paidItems()
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as sold'), DB::raw('SUM(order_items.subtotal) as revenue'))
            ->groupBy('order_items.product_id')
            ->orderByDesc('sold')
            ->take(6)
            ->get();
        $bestSellerProducts = Product::whereIn('id', $bestSellerRows->pluck('product_id'))->get()->keyBy('id');
        $bestSellers = $bestSellerRows->map(function ($row) use ($bestSellerProducts) {
            $row->product = $bestSellerProducts->get($row->product_id);
            return $row;
        })->filter(fn ($row) => $row->product);

        // Pesanan terbaru
        $recentOrders = (clone $ordersQuery)
            ->with(['items.product', 'user'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'summaryCards',
            'salesChart',
            'bestSellers',
            'recentOrders',
            'totalUsers',
            'totalVillages',
            'totalProducts',
            'totalCategories',
            'activeProducts',
            'inactiveProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'recentProducts',
            'topVillages',
            'categoryStats',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'productsByType',
            'needsShippingSetup'
        ));
    }
}
