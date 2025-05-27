
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip curl libpq-dev git zip libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /var/www/html
COPY . .
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
