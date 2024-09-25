# ベースイメージを指定
FROM php:8.2.10-fpm

# 必要なパッケージのインストール
RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

# php.iniの設定
COPY ./docker/php/php.ini /usr/local/etc/php/

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && composer self-update

# アプリケーションソースをコピー
COPY ./src /var/www/html

WORKDIR /var/www/html

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
