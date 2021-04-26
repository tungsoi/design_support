<?php

namespace App\Admin\Controllers\Furn;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(12);
        $categories = Category::all();
        return view('furns.product', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::find($id);

        return view('furns.product-detail', compact('product'));
    }
}
