FROM php:7.3-fpm-alpine

RUN set -ex \
  && apk --no-cache add \
    mariadb-dev

RUN docker-php-ext-install mysqli

COPY src/ /var/www/html/