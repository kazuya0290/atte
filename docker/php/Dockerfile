# ベースイメージを指定
FROM php:8.2.10-fpm

# php.iniの設定
COPY ./docker/php/php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

# Nginxの設定ファイルをコピー
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# アプリケーションソースをコピー
COPY ./src /var/www/html

WORKDIR /var/www/html

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Composerで依存関係をインストール
RUN composer install --no-dev --optimize-autoloader

# アプリケーションキーの生成と設定
RUN php artisan key:generate --no-interaction

# アクセス権限は適宜変えてください。
RUN chmod -R 777 ./ 

# データベースのマイグレーション
RUN php artisan migrate --force

# ポートのエクスポート
EXPOSE 80

# Nginxを起動
CMD ["nginx", "-g", "daemon off;"]
