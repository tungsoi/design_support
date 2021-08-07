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
//        $menu_arr = [];
//        foreach ($category_menu_res as $menu) {
//            $parent = $menu->toArray();
//            $parent['type'] = 'level_1';
//            $menu_arr[] = $parent;
//
//            if ($menu->childrens->count() > 0) {
//                foreach ($menu->childrens as $level_2) {
//                    $lv2 = $level_2->toArray();
//                    $lv2['type'] = 'level_2';
//                    $menu_arr[] = $lv2;
//
//                    if ($level_2->childrens->count() > 0) {
//                        foreach ($level_2->childrens as $level_3) {
//                            $lv3 = $level_3->toArray();
//                            $lv3['type'] = 'level_3';
//                            $menu_arr[] = $lv3;
//                        }
//                    }
//                }
//            }
//        }
//
//        $category_menu = $menu_arr;
        return view('furns.index', compact('categorie_row_1', 'categorie_row_2', 'products', 'category_menu'));
    }

    public function aboutus()
    {

        $category_menu = Category::all();
        return view('furns.aboutus', compact('category_menu'));
    }

    public function contact()
    {

        $category_menu = Category::all();
        return view('furns.contact', compact('category_menu'));
    }

    public function blog()
    {
        return view('furns.blog');
    }
}
