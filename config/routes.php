<?php

// Définition des routes disponibles
$routes = [
    'home' => [
        'index' => true
    ],
    'product' => [
        'list' => true,
        'detail' => true,
        'search' => true
    ],
    'cart' => [
        'view' => true,
        'add' => true,
        'update' => true,
        'remove' => true,
        'clear' => true,
        'checkout' => true,
        'processOrder' => true,
        'confirmation' => true
    ],
    'user' => [
        'login' => true,
        'doLogin' => true,
        'logout' => true,
        'register' => true,
        'doRegister' => true,
        'profile' => true,
        'updateProfile' => true,
        'orders' => true
    ],
    'admin' => [
        'dashboard' => true,
        'products' => true,
        'addProduct' => true,
        'editProduct' => true,
        'deleteProduct' => true,
        'categories' => true,
        'addCategory' => true,
        'editCategory' => true,
        'deleteCategory' => true,
        'users' => true,
        'orders' => true,
        'updateOrderStatus' => true,
        // Nouvelles routes pour le carrousel
        'carousel' => true,
        'addCarouselImage' => true,
        'doAddCarouselImage' => true,
        'editCarouselImage' => true,
        'doEditCarouselImage' => true,
        'deleteCarouselImage' => true
    ]
];