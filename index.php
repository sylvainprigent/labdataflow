<?php

// settings
ini_set('display_errors', 1); 
error_reporting(E_ALL); 

// autoload ?
require __DIR__ . '/vendor/autoload.php';

// router
$router = new Mumux\Router();
$router->routerRequest();