<?php
/**
 * Configuration for MedooConnection
 * @return array
 */
return [
    'servers' => [
        'default' => [
            // required
            'server'        => env('DB_HOST', 'localhost'),
            'username'      => env('DB_USERNAME', 'root'),
            'password'      => env('DB_PASSWORD', 'root'),
            'database_type' => env('DB_TYPE', 'mysql'),
            // [optional]
            'charset'       => 'utf8',
            'port'          => env('DB_PORT', 3306),
        ],
    ],
    'databases' => [
        'default' => [
            'database_name' => env('DB_DATABASE', 'batio'),
        ],
    ],
];
