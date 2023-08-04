ARG PHP_VERSION=""

FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

RUN echo "UTC" > /etc/timezone

RUN apk update; \
    apk upgrade; \
    apk add zip unzip libzip-dev libpng-dev libxml2-dev

RUN docker-php-ext-install gd zip pdo pdo_mysql soap xml mysqli

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
