FROM php:7.4.4-fpm-alpine@sha256:95842ecdae821603b2877697d561b77c58f55511c6a19a445ed517ca204eca79
# TODO oci8 "oracle database extension'

# gd --with-freetype --with-jpeg
RUN apk add --update --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" gd

# install bcmath extension
RUN docker-php-ext-install bcmath

# install sockets extension
RUN docker-php-ext-install sockets

# mysqli, pdo, pdo_mysql, pdo_pgsql, oracle
RUN apk add --update --no-cache postgresql-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql

# xdebug
RUN docker-php-source extract \
    && apk add --no-cache --virtual .phpize-deps-configure $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del .phpize-deps-configure \
    && docker-php-source delete

# install gettext extension
RUN apk add --update --no-cache gettext-dev \
    && docker-php-ext-configure gettext \
    && docker-php-ext-install gettext

# Install ldap extension
RUN apk add --update --no-cache \
          libldap && \
      apk add --update --no-cache --virtual .docker-php-ldap-dependancies \
          openldap-dev && \
      docker-php-ext-configure ldap && \
      docker-php-ext-install ldap && \
      apk del .docker-php-ldap-dependancies

# Openbsd netcat for zbx,follow
RUN apk --no-cache add netcat-openbsd
