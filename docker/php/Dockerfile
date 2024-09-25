FROM php:7.4.9-fpm 


RUN apt-get update && apt-get install -y nginx


COPY ./docker/php/php.ini /usr/local/etc/php/

RUN apt-get install -y default-mysql-client zlib1g-dev libzip-dev unzip curl \
    && docker-php-ext-install pdo_mysql zip


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer self-update


WORKDIR /var/www


COPY . /var/www


EXPOSE 80


CMD ["sh", "-c", "service nginx start && php-fpm"]
