<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$request = Request::createFromGlobals();

$routes = include dirname(__DIR__) . '/config/routes.php';

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

try {
    $parameters = $matcher->match($request->getPathInfo());
    $controller = $parameters['_controller'];
    unset($parameters['_controller'], $parameters['_route']);
    $response = call_user_func_array($controller, $parameters);
} catch (ResourceNotFoundException $e) {
    $response = new Response('Request resource wasn\'t found. Please check if your specified URL is correct.', 404);
} catch (Throwable $e) {
    $response = new Response('An error occurred during runtime: ' . $e->getMessage(), 500);
}

$response->send();
