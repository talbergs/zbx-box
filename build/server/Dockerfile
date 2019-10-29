FROM archlinux/base

RUN pacman -Syu --noconfirm

RUN pacman -S --noconfirm procps

RUN pacman -S --noconfirm libevent
RUN pacman -S --noconfirm postgresql-libs

RUN useradd z -g root
USER z
