<?php
/*
|--------------------------------------------------------------------------
| Init The Application
|--------------------------------------------------------------------------
*/
define('APP_PATH', __DIR__.'/../app');

// Include helpers.php
require APP_PATH.'/core/Helpers.php';
require __DIR__.'/../vendor/autoload.php';

// Load Dotenv
(new Dotenv\Dotenv(__DIR__.'/../'))->load(true);

/*
|--------------------------------------------------------------------------
| Set Flight System Configuration
|--------------------------------------------------------------------------
*/
Flight::set(require APP_PATH.'/config/app.php');

/*
|--------------------------------------------------------------------------
| Flight autoload start
|--------------------------------------------------------------------------
*/
// controllers
Flight::path(Flight::get('flight.controllers.path'));

// models
Flight::path(Flight::get('flight.models.path'));

// core
Flight::path(Flight::get('flight.core.path'));
/*
|--------------------------------------------------------------------------
| Flight autoload end
|--------------------------------------------------------------------------
*/
