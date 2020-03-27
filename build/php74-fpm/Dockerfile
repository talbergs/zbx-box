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

# install oci8 extension

# INSANE!!!!!!!
# ENV LD_LIBRARY_PATH /opt/oci8/instantclient_12_1/
# RUN mkdir -p /opt/oci8


# RUN ln -s /usr/lib/libnsl.so.2 /usr/lib/libnsl.so.1

# RUN mkdir -p /opt/oci8

# RUN apk add --update --no-cache \
#     alpine-sdk \
#     coreutils \
#     automake \
#     autoconf

# RUN apk add --update --no-cache \
#     g++ \
#     gcc \
#     make \
#     libaio-dev \
#     libnsl

# RUN pecl install oci8

# RUN ln -s /usr/lib/libnsl.so.2 /usr/lib/libnsl.so.1

# COPY ./oci8/instantclient-basic-linux.x64-12.1.0.2.0.zip /opt/oci8
# COPY ./oci8/instantclient-sdk-linux.x64-12.1.0.2.0.zip /opt/oci8
# COPY ./oci8/oci8-2.1.7.tgz /opt/oci8
# RUN cd /opt/oci8 \
#     && unzip instantclient-sdk-linux.x64-12.1.0.2.0.zip \
#     && unzip instantclient-basic-linux.x64-12.1.0.2.0.zip \
#     && cd instantclient_12_1/ \
#     && ln -s libclntsh.so.12.1 libclntsh.so \
#     && ln -s libocci.so.12.1 libocci.so \
#     && cd ../ \
#     && tar xzf oci8-2.1.7.tgz \
#     && cd oci8-2.1.7

# RUN apk --no-cache add \
#     alpine-sdk \
#     coreutils \
#     automake \
#     autoconf \
#     mysql-dev \
#     postgresql-libs \
#     libxml2-dev \
#     unixodbc-dev \
#     net-snmp-dev \
#     libssh2-dev \
#     openipmi-dev \
#     openldap-dev \
#     curl-dev \
#     libevent-dev \
#     pcre-dev

# RUN ln -sf /usr/lib/libnsl.so.2 /usr/lib/libnsl.so.1
# RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oci8/instantclient_12_1
# RUN docker-php-ext-install oci8

    # && phpize \
    # && ./configure --with-oci8=shared,instantclient,/opt/oci8/instantclient_12_1 \
    # && make \
    # && make install \
    # && echo "extension=oci8.so" >> /etc/php7/conf.d/oci8.ini \
    # && cd /opt/oci8 \
    # && rm *.zip \
    # && rm *.tgz
