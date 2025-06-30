<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Infrastructure\Database\Database;
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

    public function __construct()
    {
        $db = new Database(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        );

        $this->order_repository = new OrderRepository($db->getConnection());
    }

    #[Route('', name: 'get_orders', methods: ['GET'])]
    public static function getOrders(): Response
    {
        $self = new self();
        $orders = $self->order_repository->getAllOrders();
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
    public static function getOrderById(string $id): Response
    {
        $self = new self();
        $order = $self->order_repository->getOrderById($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], 404);
        }
        
        $order_data['data'] = OrderTransformer::toDto($order);

        return new JsonResponse($order_data);
    }
}
