<?php

declare(strict_types=1);

use App\Controller\PageController;
use App\Controller\OrderController;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add('index', new Route('/', [
    '_controller' => [PageController::class, 'index']
]));

$routes->add('get_orders', new Route('/rest-api/orders', [
    '_controller' => [OrderController::class, 'getOrders']
]));

$routes->add('get_order', new Route('/rest-api/orders/{id}', [
    '_controller' => [OrderController::class, 'getOrderById']
]));

return $routes;
