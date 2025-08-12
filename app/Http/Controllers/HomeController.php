<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\LandingContent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hero = LandingContent::where('key', 'hero')->active()->first();
        $aboutUs = LandingContent::where('key', 'about-us')->active()->first();
        $categories = Category::has('products')->take(6)->get();
        $featuredProducts = Product::with('category')
            ->active()
            ->inStock()
            ->take(8)
            ->get();
        
        return view('home', compact('hero', 'aboutUs', 'categories', 'featuredProducts'));
    }
}
