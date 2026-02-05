FROM php:8.2-fpm

# 1. Installer les dépendances système (Ajout de libpq-dev ici)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install intl opcache pdo pdo_pgsql zip

# 2. Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Note : Pas besoin de répéter docker-php-ext-install à la fin,
# tout est fait dans la commande groupée au-dessus.