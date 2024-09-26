# ベースイメージとして PHP 7.4.9-fpm を使用
FROM php:7.4.9-fpm

# Nginx をインストール
RUN apt-get update && apt-get install -y nginx gettext-base

# PHP 設定ファイルをコンテナ内の適切な場所にコピー
COPY ./docker/php/php.ini /usr/local/etc/php/

# 必要なライブラリをインストールし、PHP拡張をインストール
RUN apt-get update \
    && apt-get install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN composer install --no-dev

# Composer をインストール
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# 作業ディレクトリを設定
WORKDIR /var/www

# アプリケーションの全ファイルをコンテナにコピー
COPY . /var/www

# Nginx の設定ファイルを適切な場所にコピー
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf.template

# Nginx の設定ファイル内の環境変数を解決して配置
RUN envsubst '$PORT' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# ポートを公開
EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
