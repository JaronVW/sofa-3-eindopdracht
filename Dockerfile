FROM composer:2.6.6 AS Composer
FROM php:fpm-alpine3.18 as dev

RUN apk update

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN curl -s https://get.symfony.com/cli/installer
WORKDIR /app
COPY composer.json .
RUN composer install

COPY . .

EXPOSE 8000
