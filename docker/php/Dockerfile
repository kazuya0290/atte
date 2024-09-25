FROM php:7.4.9-fpm

RUN apt-get update && apt-get install -y nginx

COPY ./docker/php/php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

RUN chmod 777 -R ./

RUN php artisan migrate

WORKDIR /var/www

COPY . /var/www

# Expose the port
EXPOSE 80

CMD ["php-fpm", "-D", "&&", "nginx", "-g", "daemon off;"]
