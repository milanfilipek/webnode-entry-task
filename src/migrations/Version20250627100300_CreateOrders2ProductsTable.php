<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250627100300_CreateOrders2ProductsTable extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create many-to-many join table orders2products';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE orders2products (
                order_id CHAR(36) NOT NULL,
                product_id CHAR(36) NOT NULL,
                quantity INT NOT NULL,
                PRIMARY KEY (order_id, product_id),
                CONSTRAINT fk_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE orders2products");
    }
}
