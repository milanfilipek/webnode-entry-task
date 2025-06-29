FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev unzip git \
    && docker-php-ext-install pdo_mysql

RUN a2enmod rewrite

COPY ../apache/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY ../src/ /var/www/html

RUN chown -R www-data:www-data /var/www/html
