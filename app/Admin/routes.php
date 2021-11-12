<?php

use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->get('/products/product_properties', 'ProductController@getProperty')->name('products.getProperty');
    $router->get('/products/product_colors', 'ProductController@getColor')->name('products.getColor');
    $router->get('/products/product_prices', 'ProductController@getPrice')->name('products.getPrice');
    $router->get('/products/product_property_price', 'ProductController@getPriceFromProperty')->name('products.getPriceFromProperty');
    $router->get('/products/products_pictures', 'ProductController@getPicture')->name('products.getPicture');
    $router->get('/products/products_info', 'ProductController@getInfoProduct')->name('products.getInfoProduct');
    $router->resources([
        'auth/users'    =>  'UserController',
        'categories'    =>  'CategoryController',
        'products'      =>  'ProductController',
        'materials'     =>  'MaterialController',
        'suppliers'     =>  'SupplierController',
        'customers'     =>  'CustomerController',
        'order_statuses'    =>  'OrderStatusController',
        'order_product_statuses'    =>  'OrderProductStatusController',
        'orders'    =>  'OrderController'
    ]);
    $router->get('orders/{order}/export-excel-detail', 'OrderController@exportExcelDetailOrder')->name('orders.exportExcelDetailOrder');

});


Route::group([
    'namespace'     => 'App\\Admin\\Controllers\\Furn',
    'middleware'    => 'web',
    'as'            => 'furn.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/about', 'HomeController@aboutus')->name('about');
    $router->get('/contact', 'HomeController@contact')->name('contact');
    $router->get('/blog', 'HomeController@blog')->name('blog');
    $router->get('/products', 'ProductController@index')->name('product');
    $router->get('/product/detail/{id}', 'ProductController@show')->name('product.detail');
    $router->get('/products/category/{code}', 'ProductController@getByCategoryCode')->name('product.product-by-category');
});


