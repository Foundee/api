FROM php:7.2-apache

RUN apt update && apt install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql

COPY foundee-api.conf /etc/apache2/sites-available/

RUN a2enmod rewrite
RUN a2dissite 000-default && a2ensite foundee-api