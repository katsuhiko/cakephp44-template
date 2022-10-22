FROM php:8.1.11-fpm-bullseye as core

RUN apt-get update \
    && apt-get install -y git libzip-dev zip unzip \
    && docker-php-ext-install zip pdo_mysql opcache \
    && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

COPY docker/php-fpm/php.ini "$PHP_INI_DIR/conf.d/"

COPY --chown=www-data:www-data . /var/www/html/

RUN php composer.phar install -n --no-dev --prefer-dist --optimize-autoloader

# https://book.cakephp.org/4/ja/installation.html#id8
RUN chown -R www-data:www-data tmp logs

USER www-data

FROM core as develop
USER root

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN php composer.phar install -n --dev --prefer-dist --optimize-autoloader

USER www-data
