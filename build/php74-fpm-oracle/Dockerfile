# OS/ARCH - linux/386
FROM php:7.4-fpm-buster@sha256:215232c33da867319f013815a8e136d4a7380ff0dafc286c11e33e80356d5a43

## install bcmath extension
RUN docker-php-ext-install bcmath

## install sockets extension
RUN docker-php-ext-install sockets

RUN apt-get update

RUN apt-get install -y apt-utils
RUN apt-get install -y zlib1g-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libfreetype6-dev

## gd --with-freetype --with-jpeg
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" gd

## install oracle extension
RUN apt-get install -y alien libaio1
ADD oracle-instantclient19.6-basic-19.6.0.0.0-1.i386.rpm .
ADD oracle-instantclient19.6-devel-19.6.0.0.0-1.i386.rpm .

RUN alien -i oracle-instantclient19.6-basic-19.6.0.0.0-1.i386.rpm
RUN alien -i oracle-instantclient19.6-devel-19.6.0.0.0-1.i386.rpm

RUN docker-php-ext-install oci8

## install gettext extension
RUN docker-php-ext-install gettext
