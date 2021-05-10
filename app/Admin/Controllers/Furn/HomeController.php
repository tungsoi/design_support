<?php

namespace App\Admin\Controllers\Furn;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categorie_row_1 = Category::whereIsShowShop(Category::ACTIVE)->limit(2)->get();
        $categorie_row_2 = Category::whereIsShowShop(Category::ACTIVE)->whereNotIn('id', $categorie_row_1->pluck('id'))->limit(3)->get();
        $products = Product::orderBy('created_at', 'desc')->limit(8)->get();

        foreach ($products as $product) {
            if ($product->pictures != null && is_array($product->pictures))
            {
                // $product->avatar = asset($product->pictures[0]);
                $product->avatar = "https://picsum.photos/500";
            }
            else {
                $product->avatar = "https://picsum.photos/500";
            }
        }
        return view('furns.index', compact('categorie_row_1', 'categorie_row_2', 'products'));
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
