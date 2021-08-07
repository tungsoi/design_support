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
        $products = Product::orderBy('created_at', 'desc')->limit(12)->get();

        foreach ($products as $product) {
            if ($product->pictures != null && is_array($product->pictures))
            {
                $product->avatar = asset("uploads/".$product->pictures[0]);
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

        $category_menu = Category::whereNull('parent_id')->get();
        return view('furns.index', compact('categorie_row_1', 'categorie_row_2', 'products', 'category_menu'));
    }

    public function aboutus()
    {

        $category_menu = Category::whereNull('parent_id')->get();
        return view('furns.aboutus', compact('category_menu'));
    }

    public function contact()
    {

        $category_menu = Category::whereNull('parent_id')->get();
        return view('furns.contact', compact('category_menu'));
    }

    public function blog()
    {
        return view('furns.blog');
    }
}
