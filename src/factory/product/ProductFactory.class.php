<?php

declare(strict_types=1);

namespace App\Factory\Product;

use App\Entity\Product;

class ProductFactory
{
    /**
     * Creates a Product entity from a database row.
     *
     * @param array $row The database row containing product data.
     * @return Product The created Product entity.
     */
    public static function fromDbRow(array $row): Product
    {
        return new Product(
            $row['id'],
            $row['name'],
            floatval($row['price']),
            $row['currency']
        );
    }
}
