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

# アプリケーションキーの生成と設定
RUN php artisan key:generate

# アクセス権限は適宜変えてください。
RUN chmod 777 -R ./

RUN php artisan migrate

# ポートのエクスポート
EXPOSE 80

# Nginxを起動
CMD ["nginx", "-g", "daemon off;"]
