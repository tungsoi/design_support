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

    $router->resources([
        'auth/users'    =>  'UserController',
        'categories'    =>  'CategoryController',
        'products'      =>  'ProductController',
        'materials'     =>  'MaterialController',
        'suppliers'     =>  'SupplierController',
        'customers'     =>  'CustomerController',
        'orders'        =>  'OrderController'
    ]);

});


Route::group([
    'namespace'     => 'App\\Admin\\Controllers\\Shop',
    'middleware'    => 'web',
    'as'            => 'shop.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

});


