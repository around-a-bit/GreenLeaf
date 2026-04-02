<?php

namespace Config;

class CustomerMenu
{
    public $menus = [

        'dashboard' => [
            'label' => 'Dashboard',
            'icon'  => 'fa-home',
            'route' => 'dashboard',
        ],

        'profile' => [
            'label' => 'Profile',
            'icon'  => 'fa-user',
            'route' => 'profile',
        ],

        'orders' => [
            'label' => 'My Orders',
            'icon'  => 'fa-box',
            'route' => 'orders',
        ],

        'cart' => [
            'label' => 'Cart',
            'icon'  => 'fa-shopping-cart',
            'route' => 'cart',
        ],

        'address' => [
            'label' => 'Address',
            'icon'  => 'fa-map-marker-alt',
            'route' => 'address',
        ],

    ];
}