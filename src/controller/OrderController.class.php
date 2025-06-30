<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Infrastructure\Repository\MySQL\OrderRepository;
use App\Transformer\OrderTransformer;
use App\Transformer\OrderProductTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rest-api/orders')]
class OrderController
{
    private OrderRepository $order_repository;

    /**
     * OrderController constructor.
     *
     * @param OrderRepository $order_repository
     */
    public function __construct(OrderRepository $order_repository)
    {
        $this->order_repository = $order_repository;
    }

    #[Route('', name: 'get_orders', methods: ['GET'])]
    public function getOrders(): Response
    {
        $orders = $this->order_repository->getAllOrders();
        if ($orders === []) {
            return new JsonResponse(['error' => 'No orders found'], 200);
        }

        $output_array['data'] = [];
        foreach ($orders as $order) {
            $output_array['data'][] = OrderTransformer::toDto($order);
        }

        return new JsonResponse($output_array);
    }

    #[Route('/{id}', name: 'get_order', methods: ['GET'])]
    public function getOrderById(string $id): Response
    {
        $order = $this->order_repository->getOrderById($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], 404);
        }
        
        $order_data['data'] = OrderTransformer::toDto($order);

        return new JsonResponse($order_data);
    }
}
