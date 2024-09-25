# ベースイメージを指定
FROM php:8.2.10-fpm

# 必要なパッケージのインストール
RUN apt update \
    && apt install -y nginx unzip \
    && docker-php-ext-install pdo pdo_mysql

# php.iniの設定
COPY ./docker/php/php.ini /usr/local/etc/php/

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
