FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        libicu-dev \
        curl \
        zlib1g-dev \
        unzip \
        git \
        nano \
    && docker-php-ext-install \
        intl \
        opcache \
        bcmath \
        mbstring \
        zip \
    && pecl install xdebug \
    && docker-php-ext-enable \
        intl \
        opcache \
        mbstring \
        xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/bin

# Permission fix
RUN usermod -u 1000 www-data