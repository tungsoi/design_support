<?php

namespace App\Admin\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereIsShowShop(Category::ACTIVE)->limit(5)->get();
        return view('shop.index', compact('categories'));
    }
}
