<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250627100200_CreateProductsTable extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create products table with UUID and name';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE products (
                id CHAR(36) NOT NULL,
                name VARCHAR(255) NOT NULL,
                price INT NOT NULL,
                currency VARCHAR(3) NOT NULL,
                PRIMARY KEY(id)
            )
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE products");
    }
}
