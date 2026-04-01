<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ShopOwnerMenu extends BaseConfig
{
    public $menus = [

        'dashboard' => [
            'label' => 'Registration',
            'route' => 'dashboard',
            'icon'  => 'fa-user-check'
        ],

        'products' => [
            'label' => 'Product management',
            'route' => 'products',
            'icon'  => 'fa-leaf'
        ],

        'orders' => [
            'label' => 'Order management',
            'route' => 'orders',
            'icon'  => 'fa-box'
        ],

        'finance' => [
            'label' => 'Finance & commission',
            'route' => 'finance',
            'icon'  => 'fa-money-bill'
        ],

        'map' => [
            'label' => 'Map & location',
            'route' => 'map',
            'icon'  => 'fa-map'
        ],

        'tickets' => [
            'label' => 'Ticketing & support',
            'route' => 'tickets',
            'icon'  => 'fa-headset'
        ],
    ];
}