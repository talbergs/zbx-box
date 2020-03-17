FROM ruby:2.5.1-alpine

RUN apk add make
RUN gem install sass --version='3.4.22'

WORKDIR /www

CMD ["make", "css"]
