#開発環境(localhost)↓

# FROM php:7.4.9-fpm

# COPY php.ini /usr/local/etc/php/

# RUN apt update \
#     && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
#     && docker-php-ext-install pdo_mysql zip

# RUN curl -sS https://getcomposer.org/installer | php \
#     && mv composer.phar /usr/local/bin/composer \
#     && composer self-update

# WORKDIR /var/www

# デプロイ用↓

FROM php:7.4.9-fpm

RUN apt-get update && apt-get install -y nginx gettext-base supervisor

COPY ./docker/php/php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /opt/render/project/src

COPY . /opt/render/project/src

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf.template
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN envsubst '$PORT' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
