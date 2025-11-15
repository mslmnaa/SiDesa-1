<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Village;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured Villages
        $featuredVillages = Village::active()
            ->withCount('products')
            ->having('products_count', '>', 0)
            ->take(6)
            ->get();

        $categories = Category::with(['products' => function($query) {
            $query->active()
                ->inStock()
                ->withCount(['approvedReviews as reviews_count'])
                ->withAvg(['approvedReviews as average_rating'], 'rating')
                ->latest();
        }])->has('products')->get();

        // Featured Products with village info and review stats
        $featuredProducts = Product::with(['category', 'village'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg(['approvedReviews as average_rating'], 'rating')
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        return view('user.home', compact('featuredVillages', 'categories', 'featuredProducts'));
    }

    public function about()
    {
        return view('user.about');
    }

    public function contact()
    {
        return view('user.contact');
    }
}
