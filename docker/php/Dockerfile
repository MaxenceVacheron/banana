FROM  php:8.0-apache-buster

# Setting up Apache2 conf
# COPY docker/conf/apache2/000-default.conf /etc/apache2/sites-available/

# Allowing access to Apache2
RUN chown -R www-data:www-data "/var/www"

# Letting Apache2 accessing any file.
RUN usermod -u 1000 www-data
RUN usermod -G staff www-data

RUN apt-get update && \
    apt-get install -y -qq git \
        libjpeg62-turbo-dev \
        # apt-transport-https \
        # libfreetype6-dev \
        # libmcrypt-dev \
        libssl-dev \
        zip unzip \
        # nodejs \
        # npm \
        wget \
        vim

# RUN pecl install redis && docker-php-ext-enable redis
# RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
# RUN docker-php-ext-install iconv mcrypt zip pdo pdo_mysql gd bcmath
# RUN docker-php-ext-install pdo pdo_mysql mysqlis
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer


RUN for mod in rewrite headers; do a2enmod $mod; done && service apache2 restart

EXPOSE 80

WORKDIR /var/www/html/