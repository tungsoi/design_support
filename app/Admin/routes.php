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

    $router->resources([
        'auth/users'    =>  'UserController',
        'categories'    =>  'CategoryController',
        'products'      =>  'ProductController',
        'materials'     =>  'MaterialController',
        'suppliers'     =>  'SupplierController',
        'customers'     =>  'CustomerController'
    ]);

});


Route::group([
    'namespace'     => 'App\\Admin\\Controllers\\Shop',
    'middleware'    => 'web',
    'as'            => 'shop.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

});


