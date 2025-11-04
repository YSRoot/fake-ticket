FROM php:8.4-fpm

ENV COMPOSER_MEMORY_LIMIT='-1'

ARG WWWGROUP=1000
ARG WWWUSER=1317

WORKDIR /var/www

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        passwd \
        libzip-dev \
        libz-dev \
        libzip-dev \
        libpq-dev \
        libssl-dev \
        openssh-server \
        libmagickwand-dev \
        libreadline-dev \
        libgmp-dev \
        unzip \
        supervisor \
        libonig-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install mbstring extention
RUN docker-php-ext-install mbstring && docker-php-ext-enable mbstring

# Install for image manipulation
RUN docker-php-ext-install exif

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Install the PHP pdo_pgsql extention
RUN docker-php-ext-install pdo_pgsql

# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install the PHP intl extention
RUN docker-php-ext-install intl

# Install the PHP gmp extention
RUN docker-php-ext-install gmp

# Install the PHP sockets extention
# RUN docker-php-ext-install sockets

# Install the PHPRedis extention
# RUN pecl install redis && docker-php-ext-enable redis

# Install the PHP gd library
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
#     docker-php-ext-install gd

#####################################
# Composer:
#####################################
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Source the bash
RUN . ~/.bashrc

RUN groupadd -f -g $WWWGROUP www-data && \
    (id -u www-data >/dev/null 2>&1 || useradd -mU -s /bin/bash -g $WWWGROUP -u $WWWUSER www-data)

COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/php-fpm/local.ini /usr/local/etc/php/conf.d/local.ini

COPY docker/php-fpm/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

USER www-data

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
