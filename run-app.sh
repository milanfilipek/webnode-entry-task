#!/bin/bash

echo "Starting the setup for the Webnode Entry Task..."

echo "Starting docker-compose..."
docker compose -f docker/docker-compose.yml up -d --build

echo "Waiting for the MySQL database to be ready on port 3306..."
until docker exec docker-db-1 mysqladmin ping -h"127.0.0.1" --silent; do
  sleep 2
done

echo "Database is ready."

echo "Waiting for the docker-app-1 container to be ready..."
until docker exec docker-app-1 php -v &>/dev/null; do
  sleep 1
done

echo "Running composer install..."
docker exec docker-app-1 composer install --no-interaction --optimize-autoloader

echo "Running Doctrine migrations..."
docker exec docker-app-1 php vendor/bin/doctrine-migrations --configuration=config/doctrine_config.php migrate

echo "Done. Feel free to access the application at http://localhost:8080."