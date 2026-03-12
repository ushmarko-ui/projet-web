FROM php:8.4-alpine

RUN apk add --no-cache zip unzip curl git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_NOTICE" > /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www
COPY . .
RUN composer install