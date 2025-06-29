<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PageController
{
    public static function index(): Response
    {
        $html = file_get_contents(__DIR__ . '/../public/index.html');

        return new Response($html);
    }
}
