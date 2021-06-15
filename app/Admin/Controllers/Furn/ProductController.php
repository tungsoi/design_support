<?php

namespace App\Admin\Controllers\Furn;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(8);
        $categories = Category::all();

        $count = Product::all()->count();
        foreach ($products as $product) {
            if ($product->pictures != null && is_array($product->pictures))
            {
                $product->avatar = asset("uploads/".$product->pictures[0]);
                // $product->avatar = "https://picsum.photos/500";
            }
            else {
                $product->avatar = "https://picsum.photos/500";
            }
        }
        return view('furns.product-list', compact('products', 'categories', 'count'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product->pictures != null && is_array($product->pictures))
        {
            $product->avatar = asset("uploads/".$product->pictures[0]);
        }
        else {
            $product->avatar = "https://picsum.photos/500";
        }

        $category_menu = Category::all();
        return view('furns.product-detail', compact('product', 'category_menu'));
    }

    public function getByCategoryCode($code, Request $request) {
        $category = Category::whereCode($code)->first();
        $products = Product::whereCategoryId($category->id)->orderBy('id', 'desc')->get();

        foreach ($products as $product) {
            if ($product->pictures != null && is_array($product->pictures))
            {
                $product->avatar = asset("uploads/".$product->pictures[0]);
                // $product->avatar = "https://picsum.photos/500";
            }
            else {
                $product->avatar = "https://picsum.photos/500";
            }
        }
        $count = $category->products->count();
        $price = "Liên hệ";

        if ($product->properties->count() > 0)
        {
            $price = $product->properties->first()->price;
            $price = number_format($price) . " VND";
        }

        $product->price = $price;

        $category_menu = Category::all();
        return view('furns.product-category', compact('products', 'category', 'count', 'category_menu'));
    }
}
