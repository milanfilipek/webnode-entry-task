<?php

declare(strict_types=1);

use App\Infrastructure\Database\Database;
use App\Factory\Database\DatabaseFactory;
use App\Infrastructure\Repository\MySQL\OrderRepository;
use App\Controller\OrderController;
use App\Controller\PageController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function(ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set(Database::class)
        ->factory([DatabaseFactory::class, 'create']);

    $services->set(OrderRepository::class);
    $services->set(OrderController::class); 
    $services->set(PageController::class);
};