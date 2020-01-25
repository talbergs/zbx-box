FROM archlinux/base

RUN pacman -Syu --noconfirm

WORKDIR /tmp

RUN pacman -S --noconfirm \
    grep \
    awk \
    gcc \
    libxml2 \
    make \
    postgresql-libs \
    libpng \
    libjpeg-turbo \
    pkgconf \
    oniguruma \
    tar \
    autoconf

ADD freetype-2.10.1.tar.xz .
WORKDIR /tmp/freetype-2.10.1
RUN ./configure \
    --prefix=/usr \
    --enable-freetype-config \
    --disable-static

RUN make && make install

WORKDIR /tmp
RUN curl https://www.php.net/distributions/php-7.2.27.tar.gz -L -o php
RUN echo "e00ace5e89cb162cba0aebd17144541e1c4d965589155a44ca706d9f9c5a8981 php" | sha256sum -c
RUN tar -xf php

WORKDIR /tmp/php-7.2.27
RUN ./configure \
    --with-pgsql \
    --enable-bcmath \
    --enable-mbstring \
    --enable-sockets \
    --with-gd \
    --with-gettext \
    --with-ldap \
    --with-jpeg-dir \
    --with-freetype-dir \
    --with-config-file-scan-dir=/etc/php.d \
    --prefix=/usr/local

RUN make && make install

COPY locale.gen /etc/locale.gen
RUN locale-gen
RUN pacman -S --noconfirm gettext

WORKDIR /tmp
RUN curl https://github.com/xdebug/xdebug/archive/2.9.1.tar.gz -L -o xdebug
RUN echo "06a83c4612e7a1c220beded16b9f390f8813e1bcc0dcc96c3c801187fcdb6772 xdebug" | sha256sum -c
RUN tar -xf xdebug

WORKDIR /tmp/xdebug-2.9.1
RUN ./rebuild.sh

EXPOSE 9000

CMD ["/usr/local/bin/php-cgi", "-b", "0.0.0.0:9000"]
