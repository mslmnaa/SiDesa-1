<?php
// Simple test to check if categories are loaded properly

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;

echo "=== TESTING CATEGORIES ===\n";
echo "Total categories: " . Category::count() . "\n";

echo "\nBarang categories:\n";
$barangCategories = Category::where('type', 'barang')->get();
foreach ($barangCategories as $cat) {
    echo "- ID: {$cat->id} | {$cat->name}\n";
}

echo "\nJasa categories:\n";
$jasaCategories = Category::where('type', 'jasa')->get();
foreach ($jasaCategories as $cat) {
    echo "- ID: {$cat->id} | {$cat->name}\n";
}

echo "\nTesting Admin Controller:\n";
$categories = Category::all();
echo "Categories passed to admin view: " . $categories->count() . "\n";
foreach ($categories as $cat) {
    echo "- {$cat->name} (type: {$cat->type})\n";
}