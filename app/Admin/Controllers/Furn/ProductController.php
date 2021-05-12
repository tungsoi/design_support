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

        return view('furns.product-detail', compact('product'));
    }

    public function getByCategoryCode($code, Request $request) {
        $category = Category::whereCode($code)->first();
        $products = Product::whereCategoryId($category->id)->paginate(8);

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
        return view('furns.product-category', compact('products', 'category', 'count'));
    }
}
