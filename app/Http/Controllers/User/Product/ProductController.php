<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active()->inStock();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        // Price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $products = $query->paginate(12);
        $categories = Category::has('products')->get();
        
        return view('user.products.index', compact('products', 'categories'));
    }
    
    public function show(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->take(4)
            ->get();
            
        return view('user.products.show', compact('product', 'relatedProducts'));
    }
    
    public function category(Category $category)
    {
        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->active()
            ->inStock()
            ->paginate(12);
            
        return view('user.products.category', compact('products', 'category'));
    }

    public function byType($type, Request $request)
    {
        // Validate type parameter
        if (!in_array($type, ['barang', 'jasa'])) {
            abort(404);
        }

        $query = Product::with('category')->active()->inStock()->where('type', $type);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        // Price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $products = $query->paginate(12);
        $categories = Category::where('type', $type)->has('products')->get();
        
        $typeLabel = $type === 'barang' ? 'Produk Barang' : 'Produk Jasa';
        
        return view('user.products.type', compact('products', 'categories', 'type', 'typeLabel'));
    }
}
