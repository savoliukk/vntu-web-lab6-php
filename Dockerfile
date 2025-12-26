FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql mysqli

RUN echo "date.timezone=Europe/Kyiv" > /usr/local/etc/php/conf.d/timezone.ini
