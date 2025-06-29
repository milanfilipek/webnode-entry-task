<?php

declare(strict_types=1);

namespace App\Factory\Order;

use App\Entity\Order;

class OrderFactory
{
    /**
     * Creates an Order entity from a database row.
     *
     * @param array $row The database row containing order data.
     * @return Order The created Order entity.
     */
    public static function fromDbRow(array $row): Order
    {
        return new Order(
            $row['id'],
            new \DateTimeImmutable($row['created_at']),
            $row['name'],
            floatval($row['total_price']),
            $row['currency'],
            intval($row['status']),
            []
        );
    }
}
