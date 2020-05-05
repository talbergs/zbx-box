FROM alpine:3.11.3@sha256:c40c013324aa73f430d33724d8030c34b1881e96b23f44ec616f1caf8dbf445f

ENV AR_FLAGS=cr
ENV MAKEFLAGS=j9

RUN apk --update --no-cache add \
    alpine-sdk \
    coreutils \
    automake \
    autoconf \
    mysql-dev \
    postgresql-libs \
    libxml2-dev \
    unixodbc-dev \
    net-snmp-dev \
    libssh2-dev \
    openipmi-dev \
    openldap-dev \
    curl-dev \
    libevent-dev \
    pcre-dev

# Styles builder.
# Note: verison must nut be changed because of workflow.
RUN apk --update --no-cache add ruby
RUN gem install sass --version='3.4.22'

# Openbsd netcat for zbx,follow
RUN apk --update --no-cache add netcat-openbsd

# Bash for bash programms (for locale generator)
RUN apk --update --no-cache add bash gettext

# This image is used to run zabbix_server also.
RUN apk --update --no-cache add postgresql-dev
RUN adduser zabbix --disabled-password
RUN apk --update --clean-protected --no-cache add sqlite-dev
USER zabbix
