FROM archlinux/base
WORKDIR /tmp
RUN pacman -Syu --noconfirm

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
    tar

ADD freetype-2.10.1.tar.xz .
WORKDIR /tmp/freetype-2.10.1
RUN ./configure \
    --prefix=/usr \
    --enable-freetype-config \
    --disable-static

RUN make && make install

WORKDIR /tmp
RUN curl https://downloads.php.net/~derick/php-7.4.0RC5.tar.gz -o php74rc5
RUN tar -xf php74rc5

WORKDIR /tmp/php-7.4.0RC5
RUN ./configure \
    --with-pgsql \
    --enable-bcmath \
    --enable-mbstring \
    --enable-sockets \
    --enable-gd \
    --with-gettext \
    --with-ldap \
    --with-jpeg \
    --with-freetype \
    --with-config-file-scan-dir=/etc/php.d \
    --prefix=/usr/local

RUN make && make install

COPY locale.gen /etc/locale.gen
RUN locale-gen
RUN pacman -S --noconfirm gettext

EXPOSE 9000

CMD ["/usr/local/bin/php-cgi", "-b", "0.0.0.0:9000"]
