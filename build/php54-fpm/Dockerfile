# Docs: https://github.com/chialab/docker-php/blob/master/5.4/fpm/Dockerfile
# it is ubuntu/debian from docker-hub/php official
FROM php:5.4.45-fpm@sha256:b8e42519a65cf21787c1662c7106d0f470b498284b3cd9abb2eb135635419434
RUN apt-get -y update
# TODO oci8 "oracle database extension'

# install bcmath extension
RUN docker-php-ext-install bcmath

# install sockets extension
RUN docker-php-ext-install sockets

# install pgsql and mysql extension
RUN apt-get -y install php5-pgsql php5-mysql libpq-dev
RUN docker-php-ext-install mysqli pgsql

# install mbstring extension
RUN docker-php-ext-configure mbstring \
    && docker-php-ext-install mbstring

# install gettext extension
RUN docker-php-ext-configure gettext \
    && docker-php-ext-install gettext

# install gd extension
RUN apt-get -y install libjpeg-dev libpng-dev libfreetype6-dev
RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/ \
        --with-jpeg-dir=/usr/ \
        --with-png-dir=/usr/ \
    && docker-php-ext-install gd

# install opcache extension
RUN pecl install zendopcache
RUN docker-php-ext-enable opcache.so

# install ldap extension
RUN apt-get -y install libldap2-dev
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap
