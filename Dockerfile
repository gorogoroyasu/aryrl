FROM php:7.3-alpine

WORKDIR /php
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
