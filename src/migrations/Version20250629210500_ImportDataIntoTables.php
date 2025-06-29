<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250629210500_ImportDataIntoTables extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert 3 products, 4 orders with calculated total price, quantities and link them in orders2products';
    }

    public function up(Schema $schema): void
    {
        $products_data = [
            ['id' => $this->generateUuid(), 'name' => 'Product A', 'price' => 100, 'currency' => 'EUR'],
            ['id' => $this->generateUuid(), 'name' => 'Product B', 'price' => 30000, 'currency' => 'CZK'],
            ['id' => $this->generateUuid(), 'name' => 'Product C', 'price' => 1500, 'currency' => 'CZK'],
        ];

        foreach ($products_data as $product) {
            $this->addSql(
                'INSERT INTO products (id, name, price, currency) VALUES (?, ?, ?, ?)',
                [$product['id'], $product['name'], $product['price'], $product['currency']]
            );
        }

        $orders = [
            [
                'id' => $this->generateUuid(),
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'name' => 'Order 1',
                'products' => [ ['name' => 'Product A', 'quantity' => 1] ],
            ],
            [
                'id' => $this->generateUuid(),
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'name' => 'Order 2',
                'products' => [
                    ['name' => 'Product B', 'quantity' => 1],
                    ['name' => 'Product C', 'quantity' => 2],
                ],
            ],
            [
                'id' => $this->generateUuid(),
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'name' => 'Order 3',
                'products' => [ ['name' => 'Product B', 'quantity' => 1] ],
            ],
            [
                'id' => $this->generateUuid(),
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'name' => 'Order 4',
                'products' => [ ['name' => 'Product C', 'quantity' => 3] ],
            ],
        ];

        foreach ($orders as $order) {
            $total_price = 0;
            $currency = null;

            foreach ($order['products'] as $prod) {
                $product = $this->getProductByName($prod['name'], $products_data);
                if ($product) {
                    $total_price += $product['price'] * $prod['quantity'];
                    if ($currency === null) {
                        $currency = $product['currency'];
                    }
                }
            }

            $status = random_int(1, 5);

            $this->addSql(
                'INSERT INTO orders (id, created_at, name, total_price, currency, status) VALUES (?, ?, ?, ?, ?, ?)',
                [$order['id'], $order['created_at'], $order['name'], $total_price, $currency, $status]
            );

            foreach ($order['products'] as $products) {
                if (!key_exists('name', $products)) {
                    foreach ($products as $product_from_order) {
                        $product = $this->getProductByName($product_from_order['name'], $products_data);
                        if ($product) {
                            $this->addSql(
                                'INSERT INTO orders2products (order_id, product_id, quantity) VALUES (?, ?, ?)',
                                [$order['id'], $product['id'], $product_from_order['quantity']]
                            );
                        }
                    }
                } else {
                    $product = $this->getProductByName($products['name'], $products_data);
                    if ($product) {
                        $this->addSql(
                            'INSERT INTO orders2products (order_id, product_id, quantity) VALUES (?, ?, ?)',
                            [$order['id'], $product['id'], $products['quantity']]
                        );
                    }
                }
            }
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM orders2products');
        $this->addSql('DELETE FROM orders');
        $this->addSql('DELETE FROM products');
    }

    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff), random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
        );
    }

    private function getProductByName(string $name, array $products): ?array
    {
        foreach ($products as $product) {
            if ($product['name'] === $name) {
                return $product;
            }
        }
        return null;
    }
}
