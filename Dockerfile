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

# 1.5 Installer Xdebug pour le debugging
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Configurer Xdebug
RUN echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# 2. Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3. Copier et configurer l'entrypoint pour migrations automatiques
COPY docker/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

# Note : Pas besoin de répéter docker-php-ext-install à la fin,
# tout est fait dans la commande groupée au-dessus.