# ベースイメージを指定
FROM php:7.4.9-fpm

# Nginxのインストール
RUN apt-get update && apt-get install -y nginx

# php.iniの設定
COPY ./docker/php/php.ini /usr/local/etc/php/

# 必要なパッケージのインストール
RUN apt-get update \
    && apt-get install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# アプリケーションソースをコピー
WORKDIR /var/www
COPY . /var/www

# アクセス権限の設定
RUN chmod 777 -R ./

# Composerで依存関係をインストール
RUN composer install --no-dev --optimize-autoloader

# アプリケーションキーの生成
RUN php artisan key:generate --no-interaction

# データベースのマイグレーション
RUN php artisan migrate --force

# ポートのエクスポート
EXPOSE 80

# Nginxを起動
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
