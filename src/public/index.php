<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Routing\AttributeControllerLoader;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AttributeDirectoryLoader;

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);

$loader = new AttributeDirectoryLoader(
    new FileLocator(),
    new AttributeControllerLoader()
);

$routes = $loader->load(dirname(__DIR__) . '/controller');

$matcher = new UrlMatcher($routes, $context);

try {
    $parameters = $matcher->match($request->getPathInfo());

    $controller_string = $parameters['_controller'];
    unset($parameters['_controller'], $parameters['_route']);

    [$controller_class, $controller_method] = explode('::', $controller_string);

    $controller_instance = new $controller_class();

    $response = $controller_instance->$controller_method(...array_values($parameters));
} catch (ResourceNotFoundException $e) {
    $response = new Response('Request resource wasn\'t found. Please check if your specified URL is correct.', 404);
} catch (InvalidArgumentException $e) {
    $response = new Response('Invalid argument provided: ' . $e->getMessage(), 400);
} catch (Throwable $e) {
    $response = new Response('An error occurred during runtime: ' . $e->getMessage(), 500);
}

$response->send();
