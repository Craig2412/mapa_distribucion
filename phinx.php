<?php

return

[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/resources/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/resources/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',//
            'name' => 'distribucion',
            'user' =>'root',// 'root',//
            'pass' => '',
            'port' => '3306',//
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',//
            'name' => 'distribucion',
            'user' =>'root',// 'root',//
            'pass' => '',
            'port' => '3306',//
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',//
            'name' => 'distribucion',
            'user' =>'root',// 'root',//
            'pass' => '',
            'port' => '3306',//
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];


////////////////////////MYSQL/////////////////////////////////////
/*
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/resources/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/resources/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',//
            'name' => 'discard',
            'user' => 'root',//
            'pass' => '',
            'port' => '3306',//
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',//
            'name' => 'discard',
            'user' => 'root',//
            'pass' => '',
            'port' => '3306',//
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',//
            'name' => 'discard',
            'user' => 'root',//
            'pass' => '',
            'port' => '3306',//
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
*/