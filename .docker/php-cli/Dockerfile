FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    libxml2-dev \
    libsodium-dev \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libcurl4 \
    libcurl4-openssl-dev

RUN docker-php-ext-install zip sodium bcmath json curl

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update

RUN pecl install xdebug-3.1.5 && docker-php-ext-enable xdebug
COPY conf/xdebug.ini /usr/local/etc/php/conf.d/

WORKDIR /app
