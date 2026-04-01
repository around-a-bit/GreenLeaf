<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// ================= PUBLIC =================

// Homepage
$routes->get('/', 'Home::index');

// -------- CUSTOMER --------
$routes->get('customer/login', 'Customer\Auth::login', ['as' => 'customer.login']);
$routes->post('customer/login', 'Customer\Auth::loginPost');

$routes->get('customer/register', 'Customer\Auth::register');
$routes->post('customer/register', 'Customer\Auth::registerPost');


// -------- SHOP OWNER --------
$routes->get('shopOwner/login', 'ShopOwner\Auth::login', ['as' => 'shop.login']);
$routes->post('shopOwner/login', 'ShopOwner\Auth::loginPost');

$routes->get('shopOwner/register', 'ShopOwner\Auth::register');
$routes->post('shopOwner/register', 'ShopOwner\Auth::registerPost');


// -------- ADMIN --------
$routes->get('admin/login', 'Admin\Auth::login', ['as' => 'admin.login']);
$routes->post('admin/login', 'Admin\Auth::loginPost');


// -------- DELIVERY --------
$routes->get('delivery/login', 'Delivery\Auth::login', ['as' => 'delivery.login']);
$routes->post('delivery/login', 'Delivery\Auth::loginPost');


// ================= AUTH REQUIRED =================

// CUSTOMER
$routes->group('customer', ['filter' => 'auth:customer'], function ($routes) {
    $routes->get('dashboard', 'Customer\Dashboard::index');
    $routes->get('orders', 'Customer\Order::index');
});

// SHOP OWNER
$routes->group('shop', ['filter' => 'auth:shop'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Shop\Dashboard::index');

    // Shop Setup (VERY IMPORTANT)
    $routes->get('create-shop', 'Shop\ShopController::create');
    $routes->post('store-shop', 'Shop\ShopController::store');

    // Shop Profile
    $routes->get('my-shop', 'Shop\ShopController::index');
    $routes->get('edit-shop/(:num)', 'Shop\ShopController::edit/$1');
    $routes->post('update-shop/(:num)', 'Shop\ShopController::update/$1');

    // Products (locked until approved)
    $routes->get('products', 'Shop\ProductController::index');
    $routes->get('products/create', 'Shop\ProductController::create');
    $routes->post('products/store', 'Shop\ProductController::store');

});

// ADMIN

$routes->group('admin', ['filter' => 'auth:super_admin,sub_admin'], function ($routes) {

    $routes->get('dashboard', 'Admin\Dashboard::index', ['filter' => 'permission:dashboard']);

    $routes->get('list-admin', 'Admin\AdminController::index', ['filter' => 'permission:admin_management']);

    $routes->get('create-admin', 'Admin\AdminController::create', ['filter' => 'permission:admin_management']);

    $routes->post('store-admin', 'Admin\AdminController::store', ['filter' => 'permission:admin_management']);

    $routes->get('edit-admin/(:num)', 'Admin\AdminController::edit/$1', ['filter' => 'permission']);
    $routes->post('update-admin/(:num)', 'Admin\AdminController::update/$1', ['filter' => 'permission']);

    $routes->post('logout', 'Admin\Auth::logout');
});

// DELIVERY
$routes->group('delivery', ['filter' => 'auth:delivery'], function ($routes) {
    $routes->get('dashboard', 'Delivery\Dashboard::index');
    $routes->get('orders', 'Delivery\Order::index');
});
