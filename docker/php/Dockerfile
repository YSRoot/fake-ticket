FROM dunglas/frankenphp:1.9-builder-php8.4-alpine

ENV COMPOSER_MEMORY_LIMIT='-1'

RUN apk update && apk add --no-cache \
    libzip-dev \
    zlib-dev \
    postgresql-dev \
    openssl-dev \
    imagemagick-dev \
    readline-dev \
    gmp-dev \
    unzip \
    oniguruma-dev

RUN install-php-extensions \
    exif \
    gd \
    zip \
    pcntl \
    opcache \
    pdo \
    intl \
    pdo_pgsql
#    redis \
#    gmp \
#    mbstring

#####################################
# Composer:
#####################################
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

COPY docker/php/local.ini $PHP_INI_DIR/local.ini

RUN chown -R www-data:www-data storage bootstrap/cache

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
