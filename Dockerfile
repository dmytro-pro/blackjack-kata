FROM php:7.4-fpm-alpine

LABEL maintainer="Dmytro Prokopenko zorkyy.name@gmail.com"

RUN apk add mysql-client
RUN apk add libzip-dev libpng libpng-dev libjpeg libjpeg-turbo-dev freetype-dev
RUN docker-php-ext-install pdo_mysql zip

# Use the default production configuration
#RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

# Override with custom opcache settings
#COPY php.ini $PHP_INI_DIR/conf.d/
COPY docker/php.ini $PHP_INI_DIR/php.ini

COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

EXPOSE 9000
