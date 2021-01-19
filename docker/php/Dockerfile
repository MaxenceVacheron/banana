FROM  php:7.1-apache

RUN apt-get update && \
    apt-get install -y -qq git \
        libjpeg62-turbo-dev \
        apt-transport-https \
        libfreetype6-dev \
        libmcrypt-dev \
        libssl-dev \
        zip unzip \
        nodejs \
        npm \
        wget \
        vim

# RUN pecl install redis && docker-php-ext-enable redis
# RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
# RUN docker-php-ext-install -j$(nproc) iconv mcrypt zip pdo pdo_mysql gd bcmath

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# COPY ./containers/yii.conf /etc/apache2/sites-available/000-default.conf

# RUN for mod in rewrite headers; do a2enmod $mod; done && service apache2 restart

EXPOSE 80

WORKDIR /var/www/html/