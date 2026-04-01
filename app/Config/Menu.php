<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Menu extends BaseConfig
{
    // public array $menus = [
    //     'dashboard',
    //     'admins',
    //     'shops',
    //     'customers',
    //     'products',
    //     'orders',
    //     'finance',
    //     'delivery',
    //     'tickets',
    //     'coupons',
    //     'settings',
    // ];

public array $menus = [

    'dashboard' => [
        'label' => 'Dashboard',
        'route' => 'dashboard',
        'icon'  => 'fa-home'
    ],

    'admins' => [
        'label' => 'Admins',
        'route' => 'list-admin',
        'icon'  => 'fa-user-shield'
    ],

    'shops' => [
        'label' => 'Shops',
        'route' => 'shops',
        'icon'  => 'fa-store'
    ],

    'customers' => [
        'label' => 'Customers',
        'route' => 'customers',
        'icon'  => 'fa-users'
    ],

    'products' => [
        'label' => 'Products',
        'route' => 'products',
        'icon'  => 'fa-box'
    ],

    'orders' => [
        'label' => 'Orders',
        'route' => 'orders',
        'icon'  => 'fa-cart-shopping'
    ],

    'finance' => [
        'label' => 'Finance',
        'route' => 'finance',
        'icon'  => 'fa-wallet'
    ],

    'delivery' => [
        'label' => 'Delivery',
        'route' => 'delivery',
        'icon'  => 'fa-truck'
    ],

    'tickets' => [
        'label' => 'Tickets',
        'route' => 'tickets',
        'icon'  => 'fa-ticket'
    ],

    'coupons' => [
        'label' => 'Coupons',
        'route' => 'coupons',
        'icon'  => 'fa-tags'
    ],

    'settings' => [
        'label' => 'Settings',
        'route' => 'settings',
        'icon'  => 'fa-gear'
    ],

];
}