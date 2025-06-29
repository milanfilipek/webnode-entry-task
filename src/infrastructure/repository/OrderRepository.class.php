<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\OrderRepositoryInterface;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Factory\Order\OrderFactory;
use App\Factory\OrderProduct\OrderProductFactory;
use App\Factory\Product\ProductFactory;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(private \PDO $pdo) {}

    /**
     * Retrieves all orders from the database.
     *
     * @return Order[] An array of Order objects.
     */
    public function getAllOrders(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM orders");
        $orders_raw = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $orders = [];

        foreach ($orders_raw as $row) {
            $order = OrderFactory::fromDbRow($row);
            $orders[$order->getId()] = $order;
        }

        $stmt = $this->pdo->query("
            SELECT o2p.order_id, o2p.product_id, o2p.quantity, p.*
            FROM orders2products o2p
            JOIN products p ON o2p.product_id = p.id
        ");
        $order_products_raw = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($order_products_raw as $row) {
            $order_id = $row['order_id'];
            if (!isset($orders[$order_id])) {
                continue;
            }

            $order = $orders[$order_id];
            $product = ProductFactory::fromDbRow($row);

            $order_product = new OrderProduct($order, $product, intval($row['quantity']));

            $order->addItem($order_product);
        }

        return array_values($orders);
    }

    /**
     * Retrieves an order by its unique identifier from the database.
     *
     * @param string $id The unique identifier of the order.
     * 
     * @return Order|null The Order object if found, or null if not found.
     */
    public function getOrderById(string $id): ?Order
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            return null;
        }

        $order = OrderFactory::fromDbRow($row);

        $stmt_products = $this->pdo->prepare("
            SELECT o2p.quantity AS quantity, o2p.order_id, o2p.product_id, p.*
            FROM orders2products o2p 
            JOIN products p ON o2p.product_id = p.id 
            WHERE o2p.order_id = ?
        ");
        $stmt_products->execute([$id]);
        $order_products_raw = $stmt_products->fetchAll(\PDO::FETCH_ASSOC);

        if (!is_array($order_products_raw)) {
            return $order;
        }

        foreach ($order_products_raw as $row) {
            $product = ProductFactory::fromDbRow($row);
            $order_product = new OrderProduct($order, $product, intval($row['quantity']));
            $order->addItem($order_product);
        }

        return $order;
    }
}
