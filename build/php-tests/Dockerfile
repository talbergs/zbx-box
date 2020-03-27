FROM talbergs/zbx-box-php74

RUN pacman --noconfirm -Syy
RUN pacman --noconfirm -S composer

RUN mkdir /root/.composer/
RUN echo '{"config":{"disable-tls":true,"secure-http":false}}' > /root/.composer/config.json
RUN composer global require -- phpunit/phpunit:5.7.27

CMD ["phpunit", "--version"]
