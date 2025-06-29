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

    public function getOrderById(string $id): ?Order;
}
