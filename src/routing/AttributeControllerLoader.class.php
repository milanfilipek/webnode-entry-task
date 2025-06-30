<?php

declare(strict_types=1);

namespace App\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Loader\AttributeClassLoader;


class AttributeControllerLoader extends AttributeClassLoader
{
    protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, object $attribute): void
    {
        $route->setDefault('_controller', $class->getName() . '::' . $method->getName());
    }
}
