<?php

use Api\Controller\CheckoutController;
use Api\Router;
use Api\Controller\HomeController;

$router = new Router();

// Home
$router->get('/', HomeController::class, 'index');

// Checkout
$router->get('/checkout', CheckoutController::class, 'index');
$router->post('/checkout/create', CheckoutController::class, 'create');
$router->delete('/checkout/delete', CheckoutController::class, 'delete'); 
$router->put('/checkout/update', CheckoutController::class, 'update');

try {
    $router->dispatch(strtok($_SERVER['REQUEST_URI'], '?'));
} catch (\Exception $e) {
    echo $e->getMessage();
}