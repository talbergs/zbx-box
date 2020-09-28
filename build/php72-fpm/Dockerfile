# OS/ARCH - linux/386
FROM php:7.2.29-fpm-buster@sha256:f2e75e5d2bb7bb72c13bc2fda19b0ef30485206f24f88169944b0a2f9612a7d3

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
RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" gd

## install oracle extension
RUN apt-get install -y alien libaio1
ADD oracle-instantclient19.6-basic-19.6.0.0.0-1.i386.rpm .
ADD oracle-instantclient19.6-devel-19.6.0.0.0-1.i386.rpm .

RUN alien -i oracle-instantclient19.6-basic-19.6.0.0.0-1.i386.rpm
RUN alien -i oracle-instantclient19.6-devel-19.6.0.0.0-1.i386.rpm

RUN docker-php-ext-install oci8

## install ldap extension
# RUN apt-get install -y ldap-utils
# RUN apt-get install -y libldap2-dev
# RUN docker-php-ext-configure ldap --with-libdir=include/
# RUN docker-php-ext-install ldap

## install gettext extension
RUN docker-php-ext-install gettext

# Openbsd netcat for zbx,follow
RUN apt-get install -y netcat-openbsd

# Postgres
RUN apt-get install -y postgresql-server-dev-all
RUN docker-php-ext-install pgsql

# MySql
RUN docker-php-ext-install mysqli

RUN docker-php-ext-install yaml
