<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250627100100_CreateOrdersTable extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create orders table with UUID, timestamps and required fields';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE orders (
                id CHAR(36) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                name VARCHAR(255) NOT NULL,
                total_price INT NOT NULL,
                currency VARCHAR(3) NOT NULL,
                status INT NOT NULL COMMENT '1 - Delivered, 2 - Paid, 3 - Refunded, 4 - Cancelled, 5 - New',
                PRIMARY KEY(id)
            )
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE orders");
    }
}