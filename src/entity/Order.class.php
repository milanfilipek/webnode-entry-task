<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Product;

// In ideal world, this should be a database table containing all the options for statuses for easier scalability.
// But for the sake of simplicity, we will use an enum here.
// If it was PHP 7.4 or lower, we would use constants instead of enum.
enum Status: int
{
    case DELIVERED = 1;
    case PAID = 2;
    case REFUNDED = 3;
    case CANCELLED = 4;
    case NEW = 5;
}

class Order
{
    /**
     * @param string $id The unique identifier of the order.
     * @param \DateTimeImmutable $created_at The date and time when the order was created.
     * @param string $name The name of the order.
     * @param float $amount The total amount of the order.
     * @param string $currency The currency of the order amount.
     * @param int $status The status of the order.
     * @param Product[] $items An array of OrderItem entities associated with the order.
     */
    public function __construct(
        private string $id,
        private \DateTimeImmutable $created_at,
        private string $name,
        private float $amount,
        private string $currency,
        private int $status,
        private array $items
    ) {
        $this->id = $id ?? '0';
        $this->created_at = $created_at ?? new \DateTimeImmutable();
        $this->name = $name ?? '';
        $this->amount = $amount ?? 0.0;
        $this->currency = $currency ?? 'CZK';
        $this->status = $status ?? Status::NEW->value;
        $this->items = $items ?? []; 
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets the unique identifier of the order.
     *
     * @param string $id The unique identifier to set.
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }


    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeImmutable $created_at
     */
    public function setCreatedAt(\DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
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
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status The status to set.
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Product[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Product[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * Converts the Order object to an associative array.
     *
     * @return array The associative array representation of the Order object.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'name' => $this->getName(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'status' => $this->getStatus(),
            'items' => array_map(fn(Product $item) => $item->toArray(), $this->items),
        ];
    }
}    
