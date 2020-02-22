FROM php:7.2-apache

COPY foundee-api.conf /etc/apache2/sites-available/

RUN a2enmod rewrite
RUN a2dissite 000-default && a2ensite foundee-api