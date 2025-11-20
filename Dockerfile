FROM php:8.2-fpm

# Installer les extensions nécessaires à Symfony et Doctrine
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install intl opcache pdo_mysql zip

# Installer Composer (outil PHP pour gérer les dépendances)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

