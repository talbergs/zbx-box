FROM archlinux/base

RUN pacman -Syu --noconfirm

RUN pacman -S --noconfirm \
    automake \
    autoconf \
    grep \
    gcc \
    make

RUN pacman -S --noconfirm libevent
RUN pacman -S --noconfirm postgresql-libs

RUN pacman -S --noconfirm docker
RUN pacman -S --noconfirm openbsd-netcat

RUN pacman -S --noconfirm pkg-config

ENV ARFLAGS=cr
ENV MAKEFLAGS=j9
