<?php

declare(strict_types=1);

use App\Controller\PageController;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add('index', new Route('/', [
    '_controller' => [PageController::class, 'index']
]));

return $routes;
