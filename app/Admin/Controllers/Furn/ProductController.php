<?php

namespace App\Admin\Controllers\Furn;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductProperty;
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

        $price = "Liên hệ";

        if ($product->properties->count() == 1)
        {
            $price = $product->properties->first()->price;
            $price = number_format($price) . " VND";
        } else if ($product->properties->count() > 1) {
            $minPrice = (int) $product->properties->first()->price;
            $maxPrice = (int) $product->properties->first()->price;
            foreach ($product->properties as $row) {
                if ( (int) $row->price > $minPrice) {
                    $maxPrice = $row->price;
                }
                if ( (int) $row->price < $minPrice) {
                    $minPrice = $row->price;
                }
            }

            $price = number_format($minPrice) . " VND - " . number_format($maxPrice) . " VND";
        }

        $category_menu = Category::whereNull('parent_id')->get();
        return view('furns.product-detail', compact('product', 'category_menu', 'price'));
    }

    public function getByCategoryCode($code, Request $request) {
        $category = Category::whereCode($code)->first();
        $products = Product::whereCategoryId($category->id)->orderBy('id', 'desc')->get();

        foreach ($products as $product) {
            if ($product->pictures != null && is_array($product->pictures))
            {
                $avatar = isset($product->pictures[0]) ? $product->pictures[0] : $product->pictures[1];
                $product->avatar = asset("uploads/".$avatar);
                // $product->avatar = "https://picsum.photos/500";
            }
            else {
                $product->avatar = "https://picsum.photos/500";
            }


            $price = "Liên hệ";

            if ($product->properties->count() == 1)
            {
                $price = $product->properties->first()->price;
                $price = number_format($price) . " VND";
            } else if ($product->properties->count() > 1) {
                $minPrice = (int) $product->properties->first()->price;
                $maxPrice = (int) $product->properties->first()->price;
                foreach ($product->properties as $row) {
                    if ( (int) $row->price > $minPrice) {
                        $maxPrice = $row->price;
                    }
                    if ( (int) $row->price < $minPrice) {
                        $minPrice = $row->price;
                    }
                }

                $price = number_format($minPrice) . " VND - " . number_format($maxPrice) . " VND";
            }

            $product->price = $price;
        }
        $count = $category->products->count();

        $category_menu = Category::whereNull('parent_id')->get();
        return view('furns.product-category', compact('products', 'category', 'count', 'category_menu'));
    }
}
