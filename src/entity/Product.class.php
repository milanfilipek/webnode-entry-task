<?php

declare(strict_types=1);

namespace App\Entity;

class Product
{
    /**
     * @param string $name The name of the product.
     * @param float $price The price of the product.
     */
    public function __construct(
        private string $id,
        private string $name,
        private float $price,
        private string $currency
    ) {
        if ($price < 0) {
            throw new \InvalidArgumentException('Price must be a positive float.');
        }

        $this->id = $id ?? '0';
        $this->name = $name ?? '';
        $this->price = $price ?? 0.0;
        $this->currency = $currency ?? 'CZK';
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id The unique identifier to set.
     */
    public function setId(string $id): void
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('ID cannot be empty.');
        }
        $this->id = $id;
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
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price The price to set.
     */
    public function setPrice(float $price): void
    {
        if ($price < 0) {
            throw new \InvalidArgumentException('Price must be a positive float.');
        }
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    } 

    /**
     * @param string $currency The currency to set.
     */
    public function setCurrency(string $currency): void
    {
        if (empty($currency)) {
            throw new \InvalidArgumentException('Currency cannot be empty.');
        }

        $this->currency = $currency;
    }

    /**
     * Converts the Product object to an associative array.
     *
     * @return array The associative array representation of the Product.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'currency' => $this->getCurrency()
        ];
    }
}
