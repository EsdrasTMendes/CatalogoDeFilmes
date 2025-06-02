FROM php:8.2-fpm

ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    vim \
    libzip-dev \
    libssl-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/* # Limpa o cache do apt

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./src /var/www

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]