<?php

namespace App\Admin\Controllers\Furn;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereIsShowShop(Category::ACTIVE)->get();
        $products = Product::orderBy('created_at', 'desc')->limit(8)->get();
        return view('furns.index', compact('categories', 'products'));
    }

    public function aboutus()
    {
        return view('furns.aboutus');
    }

    public function contact()
    {
        return view('furns.contact');
    }

    public function blog()
    {
        return view('furns.blog');
    }
}
