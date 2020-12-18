<?php

if (!route(1)) {
    $route[1] = 'index';
}

if (!file_exists(admin_controller(route(1)))){
    $route[1] = 'index';
}

if (!session('user_rank') || session('user_rank') == 3){
    $route[1] = 'login';
}

$menu1 = [
    'index' => [
        'title' => 'Ana Gösterge Paneli',
        'icon' => 'pe-7s-rocket',
    ],
    'sequence' => [
        'title' => 'Anasayfa Dizilimi',
        'icon' => 'pe-7s-rocket',
    ],
];
$menu2 = [
    'productions' => [
        'title' => 'Yapımlar',
        'icon' => 'pe-7s-keypad',
        'submenu' => [
            'series' => 'Diziler',
            'seasons' => 'Sezonlar',
            'episodes' => 'Bölümler',
            'movies' => 'Filmler',
        ],
    ],
    'pages' => [
        'title' => 'Sayfalar',
        'icon' => 'pe-7s-note2',
    ],
    'users' => [
        'title' => 'Üyeler',
        'icon' => 'pe-7s-user',
    ],
    'settings' => [
        'title' => 'Site Ayarları',
        'icon' => 'pe-7s-config',
    ],
    'menu' => [
        'title' => 'Menü Yönetimi',
        'icon' => 'pe-7s-menu',
    ],
    'categories' => [
        'title' => 'Kategoriler',
        'icon' => 'pe-7s-albums',
    ],
];


require admin_controller(route(1));
