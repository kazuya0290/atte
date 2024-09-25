# ベースイメージを指定
FROM php:8.2.10-fpm

RUN apt update \
    && apt install -y nginx \
    && docker-php-ext-install pdo pdo_mysql

# php.iniの設定
COPY ./docker/php/php.ini /usr/local/etc/php/

# Nginxの設定ファイルをコピー
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# アプリケーションソースをコピー
COPY ./src /var/www/html

WORKDIR /var/www/html

# ここに他のコマンドを追加

# ポートのエクスポート
EXPOSE 80

# Nginxを起動
CMD ["nginx", "-g", "daemon off;"]
