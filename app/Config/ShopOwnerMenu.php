<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ShopOwnerMenu extends BaseConfig
{
public array $menus = [
    'dashboard' => [
        'route' => 'dashboard',
        'icon'  => 'fa-home',
        'label' => 'Dashboard'
    ],

    'myshop' => [
        'route' => 'my-shop',
        'icon'  => 'fa-store',
        'label' => 'My Shops'
    ],

    'products' => [
        'route' => 'products',
        'icon'  => 'fa-box',
        'label' => 'My Products'
    ],

    'orders' => [
        'route' => 'orders',
        'icon'  => 'fa-shopping-cart',
        'label' => 'Orders'
    ],

    'finance' => [
        'route' => 'finance',
        'icon'  => 'fa-wallet',
        'label' => 'Finance'
    ],

    'tickets' => [
        'route' => 'tickets',
        'icon'  => 'fa-ticket-alt',
        'label' => 'Support Tickets'
    ],
];
}