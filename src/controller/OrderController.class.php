<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController
{
    /**
     * @return Response
     */
    public static function getOrders(): Response
    {
        $order = new Order(
            '0129e936-a377-48f5-b9af-902e25f2477b',
            new \DateTimeImmutable(),
            'Test Order',
            100.0,
            'CZK',
            1,
            [
                new Product(
                    'Test Product',
                    50.0,
                    2
                )
            ]
        );

        return new JsonResponse(
            json_encode($order->toArray()),
            200,
            [],
            true
        );
    }

    /**
     * @param string $id
     * 
     * @return Response
     */
    public static function getOrderById(string $id): Response
    {
        $order = new Order(
            '0129e936-a377-48f5-b9af-902e25f2477b',
            new \DateTimeImmutable(),
            'Test Order by ID',
            100.0,
            'CZK',
            1,
            [
                new Product(
                    'Test Product',
                    50.0,
                    2
                )
            ]
        );

        return new JsonResponse(
            json_encode($order->toArray()),
            200,
            [],
            true
        );
    }
}
