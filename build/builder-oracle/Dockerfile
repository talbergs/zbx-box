# Intel chip
FROM debian:buster@sha256:1fc7e0d1007a0edc81e4302465279916f457d97b4ff6bbd92687bf0c9ca42635

RUN apt-get update
RUN apt-get install -y \
    pkg-config \
    automake \
    build-essential \
    alien \
    zlib1g-dev \
    libevent-dev \
    libpcre++-dev \
    libaio1

ADD oracle-instantclient19.6-basic-19.6.0.0.0-1.i386.rpm .
ADD oracle-instantclient19.6-devel-19.6.0.0.0-1.i386.rpm .

RUN alien -i oracle-instantclient19.6-basic-19.6.0.0.0-1.i386.rpm
RUN alien -i oracle-instantclient19.6-devel-19.6.0.0.0-1.i386.rpm

RUN adduser zabbix --disabled-password
USER zabbix
