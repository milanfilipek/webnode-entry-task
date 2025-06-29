<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\OrderProduct;

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
     * @param OrderProduct[] $items An array of OrderItem entities associated with the order.
     */
    public function __construct(
        private string $id,
        private \DateTimeImmutable $created_at,
        private string $name,
        private float $total_price,
        private string $currency,
        private int $status,
        private array $items
    ) {
        if ($total_price < 0) {
            throw new \InvalidArgumentException('Total price must be a positive float.');
        }

        $this->id = $id ?? '0';
        $this->created_at = $created_at ?? new \DateTimeImmutable();
        $this->name = $name ?? '';
        $this->total_price = $total_price ?? 0.0;
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
        if (empty($id)) {
            throw new \InvalidArgumentException('ID cannot be empty.');
        }
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
        if (!$created_at instanceof \DateTimeImmutable) {
            throw new \InvalidArgumentException('Created at must be an instance of DateTimeImmutable.');
        }
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
    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    /**
     * @param float $amount The amount to set.
     */
    public function setTotalPrice(float $total_price): void
    {
        if ($total_price < 0) {
            throw new \InvalidArgumentException('Total price must be a positive float.');
        }
        $this->total_price = $total_price;
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
     * @return OrderProduct[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderProduct[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * Adds an item to the order.
     *
     * @param OrderProduct $item The item to add to the order.
     */
    public function addItem(OrderProduct $item): void
    {
        if ($this->items === null) {
            $this->items = [];
        }
        $this->items[] = $item;
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
            'total_price' => $this->getTotalPrice(),
            'currency' => $this->getCurrency(),
            'status' => $this->getStatus(),
            'items' => array_map(fn(OrderProduct $item) => $item->toArray(), $this->items),
        ];
    }
}    
