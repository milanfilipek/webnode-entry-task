<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Order;
use App\Entity\Product;

class OrderProduct
{
    public function __construct(
        private Order $order, 
        private Product $product, 
        private int $quantity
    ) {
        $this->order = $order ?? new Order();
        $this->product = $product ?? new Product('', 0.0, 0);
        $this->quantity = $quantity ?? 1;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order The order to set.
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product The product to set.
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity The quantity to set.
     */
    public function setQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException('Quantity must be a non-negative integer.');
        }
        $this->quantity = $quantity;
    }

    /**
     * Converts the Order2Product object to an associative array.
     *
     * @return array An associative array representation of the Order2Product object.
     */
    public function toArray(): array
    {
        return [
            'product_id' => $this->getProduct()->getId(),
            'product_name' => $this->getProduct()->getName(),
            'product_price' => $this->getProduct()->getPrice(),
            'product_currency' => $this->getProduct()->getCurrency(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
