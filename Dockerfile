FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install -y unzip curl

RUN a2enmod rewrite
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf
