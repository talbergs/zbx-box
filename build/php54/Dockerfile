FROM archlinux/base

RUN pacman -Syu --noconfirm

WORKDIR /tmp

RUN curl https://www.php.net/distributions/php-5.4.45.tar.gz -o php54
RUN echo "25bc4723955f4e352935258002af14a14a9810b491a19400d76fcdfa9d04b28f  php54" | sha256sum -c
RUN pacman -S --noconfirm tar
RUN tar -xf php54

WORKDIR /tmp/php-5.4.45

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

WORKDIR /tmp/php-5.4.45
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

# RUN make test # {{{
#
# =====================================================================
# FAILED TEST SUMMARY
# ---------------------------------------------------------------------
# Test 5: HTML Test [ext/dom/tests/dom005.phpt]
# Bug #70019 Files extracted from archive may be placed outside of destination directory [ext/phar/tests/bug70019.phpt]
# SimpleXML: XPath [ext/simplexml/tests/008.phpt]
# http-stream test [ext/standard/tests/network/http-stream.phpt]
# substr_compare() [ext/standard/tests/strings/substr_compare.phpt]
# Test strptime() function : basic functionality [ext/standard/tests/time/strptime_basic.phpt]
# Bug #64230 (XMLReader does not suppress errors) [ext/xmlreader/tests/bug64230.phpt]
# =====================================================================
# 
# =====================================================================
# WARNED TEST SUMMARY
# ---------------------------------------------------------------------
# Phar: bug #69958: Segfault in Phar::convertToData on invalid file [ext/phar/tests/bug69958.phpt] (warn: XFAIL section but test passes)
# Bug #70172 - Use After Free Vulnerability in unserialize() [ext/standard/tests/serialize/bug70172.phpt] (warn: XFAIL section but test passes)
# =====================================================================
# }}}

RUN make install

RUN pacman -S --noconfirm autoconf
RUN pecl install xdebug-2.4.1
RUN pecl install zendopcache-7.0.5

COPY locale.gen /etc/locale.gen
RUN locale-gen
RUN pacman -S --noconfirm gettext

EXPOSE 9000

CMD ["/usr/local/bin/php-cgi", "-b", "0.0.0.0:9000"]
