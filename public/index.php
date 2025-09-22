<?php

declare(strict_types=1);

use App\Controllers\KitchenController;
use App\Controllers\RecipeController;
use App\Helpers;

require_once '../vendor/autoload.php';

$helper = new Helpers();
$recipeController = new RecipeController();
$kitchenController = new KitchenController();

$params = explode('/', $_GET['params']);
$controller = $params[0] ? $params[0] : 'recipe';
$method = $params[1] ? $params[1] : 'index';
$controllerCheck = strtoupper($controller[0]) . substr($controller, 1) . 'Controller';

// Check if controller exists
if (!class_exists('App\\Controllers\\' . $controllerCheck)) {
    $helper->error(404, "Controller '{$controllerCheck}' not found");
}

// Create controller instance dynamically
$controllerClass = 'App\\Controllers\\' . $controllerCheck;
$controllerInstance = ${strtolower($controller) . 'Controller'};

// Check if method exists
if (method_exists($controllerInstance, $method)) {
    $controllerInstance->$method();
} else {
    $controllerInstance->index();
}