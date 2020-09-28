# FROM php:7.4.4-fpm-alpine@sha256:95842ecdae821603b2877697d561b77c58f55511c6a19a445ed517ca204eca79
FROM php:7.4.7-buster

# FROM php:8.0-rc

RUN docker-php-ext-install sockets

RUN apt-get update
RUN apt-get install autoconf
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

CMD ["php", "/app/src/app.php"]
