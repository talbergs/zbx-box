FROM archlinux/base

RUN pacman -Syu --noconfirm

WORKDIR /tmp

RUN curl https://www.php.net/distributions/php-7.2.26.tar.gz -o php72
RUN echo "e97d0636478bb519cd955a0c17b7970cf173063a840a83fc4afb75c22bc1bf08  php72" | sha256sum -c
RUN pacman -S --noconfirm tar
RUN tar -xf php72

WORKDIR /tmp/php-7.2.26

RUN pacman -S --noconfirm grep
RUN pacman -S --noconfirm awk
RUN pacman -S --noconfirm gcc
RUN pacman -S --noconfirm libxml2

RUN pacman -S --noconfirm make
RUN pacman -S --noconfirm postgresql-libs
RUN pacman -S --noconfirm libpng
RUN pacman -S --noconfirm libjpeg-turbo

ADD freetype-2.10.1.tar.xz ..
WORKDIR /tmp/freetype-2.10.1
RUN ./configure \
    --prefix=/usr \
    --enable-freetype-config \
    --disable-static

RUN make && make install

WORKDIR /tmp/php-7.2.26
RUN ./configure \
    --with-pgsql \
    --enable-bcmath \
    --enable-mbstring \
    --enable-sockets \
    --with-gd \
    --with-gettext \
    --with-ldap \
    --with-jpeg-dir \
    --enable-gd-native-ttf \
    --with-freetype-dir \
    --with-config-file-scan-dir=/etc/php.d \
    --prefix=/usr/local

RUN make

RUN make install

RUN pacman -S --noconfirm autoconf

COPY locale.gen /etc/locale.gen
RUN locale-gen
RUN pacman -S --noconfirm gettext

EXPOSE 9000

CMD ["/usr/local/bin/php-cgi", "-b", "0.0.0.0:9000"]
