<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Entity\Order;

interface OrderRepositoryInterface
{
    /**
     * @return Order[]
     */
    public function getAllOrders(): array;

    /**
     * Retrieves an order by its unique identifier from the database.
     *
     * @param string $id The unique identifier of the order.
     * 
     * @return Order|null The Order object if found, null otherwise.
     */
    public function getOrderById(string $id): ?Order;
}
