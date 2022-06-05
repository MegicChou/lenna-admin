<?php

return [
    /*
    |--------------------------------------------------------------------------
    | HTTPS Feature
    |--------------------------------------------------------------------------
    |
    |
    */
    'https' => getenv('ADMIN_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | 站台標題設定
    |--------------------------------------------------------------------------
    |
    |
    */
    'title' => '測試',

    /*
    |--------------------------------------------------------------------------
    | 頂部選單設定
    |--------------------------------------------------------------------------
    |
    |
    */
    'top_menu' => [
        'login'     => 'https://yahoo.com.tw',
        'logout'    => 'https://yahoo.com.tw'
    ],

    /*
    |--------------------------------------------------------------------------
    | 版權宣告
    |--------------------------------------------------------------------------
    |
    |
    */
    'copyright' => 'XXXX',

    /*
    |--------------------------------------------------------------------------
    | 系統版本
    |--------------------------------------------------------------------------
    |
    |
    */
    'show_version'  => false,
    'version'       => "3.1.0",


    'middleware'    => ['web','admin'],

    'route_files'   => [
    ]
];
