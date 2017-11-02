<?php
/**
 * Batio Application Entrance
 */
require __DIR__."/../bootstrap/init.php";

Flight::before('start', ['Batio', 'bootstrap']);
Flight::start();
