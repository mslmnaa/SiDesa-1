<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Content\LandingContent;
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
        
        return view('user.home', compact('hero', 'aboutUs', 'categories', 'featuredProducts'));
    }

    public function about()
    {
        $aboutContent = LandingContent::where('key', 'about-us')->active()->first();
        return view('user.about', compact('aboutContent'));
    }

    public function contact()
    {
        return view('user.contact');
    }
}
