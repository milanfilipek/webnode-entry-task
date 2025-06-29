<?php

declare(strict_types=1);

namespace App\Entity;

class Product
{
    /**
     * @param string $name The name of the product.
     * @param float $amount The price of the product.
     * @param int $quantity The quantity of the product.
     */
    public function __construct(
        private string $name,
        private float $amount,
        private int $quantity
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount must be a positive float.');
        }
        if ($quantity < 0) {
            throw new \InvalidArgumentException('Quantity must be a non-negative integer.');
        }
        $this->name = $name ?? '';
        $this->amount = $amount ?? 0.0;
        $this->quantity = $quantity ?? 0;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name The name to set.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount The amount to set.
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
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
        $this->quantity = $quantity;
    }

    /**
     * Converts the Product object to an associative array.
     *
     * @return array The associative array representation of the Product.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'amount' => $this->getAmount(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
