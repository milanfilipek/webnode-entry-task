<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\OrderProduct;

class OrderProductTransformer
{
    /**
     * Transforms an OrderProduct object or array into an API structure.
     *
     * @param array|OrderProduct $order_product The order product to transform.
     * 
     * @return array The transformed order product data.
     */
    public static function toApiStructure(array|OrderProduct $order_product): array
    {
        return [
            'product_id'       => $order_product->getProduct()->getId(),
            'product_name'     => $order_product->getProduct()->getName(),
            'product_price'    => $order_product->getProduct()->getPrice(),
            'product_currency' => $order_product->getProduct()->getCurrency(),
            'quantity'         => $order_product->getQuantity(),
        ];
    }
}
