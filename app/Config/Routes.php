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
$routes->group('shop_owner', ['filter' => 'auth:shop_owner'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'ShopOwner\DashboardController::index');

    // Shop Setup (VERY IMPORTANT)
    $routes->get('create-shop', 'ShopOwner\ShopController::create');
    $routes->post('store-shop', 'ShopOwner\ShopController::store');

    // Shop Profile
    $routes->get('my-shop', 'ShopOwner\ShopController::index');
    $routes->get('edit-shop/(:num)', 'ShopOwner\ShopController::edit/$1');
    $routes->post('update-shop/(:num)', 'ShopOwner\ShopController::update/$1');

    // Products (locked until approved)
    $routes->get('products', 'ShopOwner\ProductController::index');
    $routes->get('products/create', 'ShopOwner\ProductController::create');
    $routes->post('products/store', 'ShopOwner\ProductController::store');

    $routes->post('logout', 'ShopOwner\Auth::logout');

});

// ADMIN

$routes->group('admin', ['filter' => 'auth:super_admin,sub_admin'], function ($routes) {

    $routes->get('dashboard', 'Admin\Dashboard::index', ['filter' => 'permission:dashboard']);

    $routes->get('list-admin', 'Admin\AdminController::index', ['filter' => 'permission:admins']);
    $routes->get('create-admin', 'Admin\AdminController::create', ['filter' => 'permission:admins']);
    $routes->post('store-admin', 'Admin\AdminController::store', ['filter' => 'permission:admins']);

    $routes->get('edit-admin/(:num)', 'Admin\AdminController::edit/$1', ['filter' => 'permission:admins']);
    $routes->post('update-admin/(:num)', 'Admin\AdminController::update/$1', ['filter' => 'permission:admins']);
    // Shop Owner Approval
    $routes->get('shopOwners', 'Admin\ShopController::index', ['filter' => 'permission:shopOwners']);
    $routes->post('shopOwners/update-status', 'Admin\ShopController::updateStatus',['filter' => 'permission:shopOwners']);
    // Product category
    $routes->get('categories', 'Admin\CategoryController::index', ['filter' => 'permission:categories']);
    $routes->post('categories/store', 'Admin\CategoryController::store', ['filter' => 'permission:categories']);
    $routes->post('categories/update/(:num)', 'Admin\CategoryController::update/$1', ['filter' => 'permission:categories']);
    $routes->post('categories/toggle/(:num)', 'Admin\CategoryController::toggle/$1', ['filter' => 'permission:categories']);
    // Product approval
    $routes->get('products', 'Admin\ProductController::index', ['filter' => 'permission:products']);
    $routes->post('products/update-status', 'Admin\ProductController::updateStatus', ['filter' => 'permission:products']);
    
    $routes->post('logout', 'Admin\Auth::logout');
});

// DELIVERY
$routes->group('delivery', ['filter' => 'auth:delivery'], function ($routes) {
    $routes->get('dashboard', 'Delivery\Dashboard::index');
    $routes->get('orders', 'Delivery\Order::index');
});
