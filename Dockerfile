FROM php:7-fpm

RUN apt-get update
RUN apt-get install -y supervisor
RUN apt-get install -y libmcrypt-dev
RUN apt-get install -y mysql-client
RUN apt-get install -y libmagickwand-dev
RUN apt-get install -y zip
RUN apt-get install -y zlib1g-dev

RUN pecl install mcrypt-1.0.1 && docker-php-ext-enable mcrypt
RUN pecl install imagick-3.4.3 && docker-php-ext-enable imagick
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install pcntl

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

WORKDIR /var/www