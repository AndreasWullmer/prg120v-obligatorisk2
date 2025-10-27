FROM php:8.4-apache
WORKDIR /var/www/html

COPY . /var/www/html

RUN docker-php-ext-install pdo pdo_mysql
