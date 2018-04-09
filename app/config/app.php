<?php
/**
 * System Configuration
 * @return array
 */
return [
    'flight.controllers.path' => dirname(__DIR__).'/controllers',
    'flight.middlewares.path' => dirname(__DIR__).'/middlewares',
    'flight.models.path'      => dirname(__DIR__).'/models',
    'flight.core.path'        => dirname(__DIR__).'/core',
    // setting url case_sensitive, default false
    'flight.case_sensitive'   => filter_var(env('CASE_SENSITIVE', true), FILTER_VALIDATE_BOOLEAN),
    'flight.log_errors'       => filter_var(env('LOG_ERROE', false), FILTER_VALIDATE_BOOLEAN),

    // database config
    'db.default' => [
        'host'    => env('DB_HOST', 'localhost'),
        'port'    => env('DB_PORT', 3306),
        'user'    => env('DB_USERNAME', 'root'),
        'pass'    => env('DB_PASSWORD', 'root'),
        'name'    => env('DB_DATABASE', 'batio'),
        'charset' => 'utf8',
    ],

    'cache.path' => dirname(__DIR__).'/storage/cache',
    'log.path'   => dirname(__DIR__).'/storage/logs',

    // auth middlewares
    'auth.middlewares' => [
        'web' => WebAuthMiddleware::class,
    ],
];
