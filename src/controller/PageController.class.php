<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PageController
{
    public static function index(): Response
    {
        return new Response('Simple test if the routing works and dotenv test - DB name is ' . $_ENV['DB_NAME']);
    }
}
