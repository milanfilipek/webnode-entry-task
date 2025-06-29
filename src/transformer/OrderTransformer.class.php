<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Order;
use App\Transformer\OrderProductTransformer;

class OrderTransformer
{
    /**
     * Transforms an Order object or array into an API structure.
     *
     * @param array|Order $order The order to transform.
     * 
     * @return array The transformed order data.
     */
    public static function toApiStructure(array|Order $order): array
    {
        return [
            'id'          => $order->getId(),
            'created_at'  => $order->getCreatedAt()->format('Y-m-d H:i:s'),
            'name'        => $order->getName(),
            'total_price' => $order->getTotalPrice(),
            'currency'    => $order->getCurrency(),
            'status'      => $order->getStatus(),
            'items'       => array_map(
                fn($order_product) => OrderProductTransformer::toApiStructure($order_product),
                $order->getItems()
            ),
        ];
    }
}
