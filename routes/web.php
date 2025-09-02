<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\Product\ProductController;
use App\Http\Controllers\User\Cart\CartController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\Infaq\InfaqController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Product\CategoryController as AdminCategoryController;
use App\Http\Controllers\SuperAdmin\User\UserController as AdminUserController;
use App\Http\Controllers\Admin\Content\LandingContentController;
use App\Http\Controllers\Admin\Infaq\InfaqController as AdminInfaqController;
use App\Http\Controllers\User\Contact\ContactController;
use App\Http\Controllers\SuperAdmin\System\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/type/{type}', [ProductController::class, 'byType'])->name('products.type');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/category/{category}', [ProductController::class, 'category'])->name('products.category');
Route::post('/products/{product}/whatsapp-inquiry', [ProductController::class, 'whatsappInquiry'])->name('products.whatsapp-inquiry');
Route::get('/infaq', [InfaqController::class, 'index'])->name('infaq');
Route::get('/infaq/create', [InfaqController::class, 'create'])->name('infaq.create');
Route::post('/infaq', [InfaqController::class, 'store'])->name('infaq.store');
Route::get('/infaq/{infaq}', [InfaqController::class, 'show'])->name('infaq.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes (Authentication Required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('user.cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('user.cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('user.cart.remove');
    
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);
    
    
    // User Management (Super Admin Only)
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
    
    // Settings Management (Super Admin Only)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/test-email', [SettingController::class, 'testEmail'])->name('settings.test-email');
    
    // Landing Content Management
    Route::resource('content', LandingContentController::class);
    Route::post('content/{landingContent}/toggle-status', [LandingContentController::class, 'toggleStatus'])->name('content.toggle-status');
    
    // Infaq Management
    Route::get('infaq', [AdminInfaqController::class, 'index'])->name('infaq.index');
    Route::get('infaq/{infaq}', [AdminInfaqController::class, 'show'])->name('infaq.show');
    Route::put('infaq/{infaq}/status', [AdminInfaqController::class, 'updateStatus'])->name('infaq.update-status');
    Route::post('infaq/{infaq}/verify', [AdminInfaqController::class, 'verifyPayment'])->name('infaq.verify');
    Route::post('infaq/{infaq}/complete', [AdminInfaqController::class, 'completeDistribution'])->name('infaq.complete');
    Route::post('infaq/{infaq}/reject', [AdminInfaqController::class, 'reject'])->name('infaq.reject');
});
