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

# ベースイメージとしてPHP 7.4 FPMを使用
FROM php:7.4.9-fpm

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y nginx gettext-base supervisor

# PHP設定ファイルのコピー
COPY ./docker/php/php.ini /usr/local/etc/php/

# MySQLクライアントやその他必要なパッケージをインストール
RUN apt-get update \
    && apt-get install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

# Composerをインストール
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# 環境変数を設定
ENV COMPOSER_ALLOW_SUPERUSER=1

# 作業ディレクトリを設定
WORKDIR /var/www

# ソースコードをコピー
COPY . /var/www

# www-dataユーザーに切り替え
USER www-data

# Composerで依存関係をインストール
RUN composer clear-cache \
    && composer install --no-dev --optimize-autoloader || { echo 'Composer install failed'; exit 1; }

# Nginxの設定ファイルをコピー
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf.template

# Supervisorの設定ファイルをコピー
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ポート環境変数を使ってNginxの設定ファイルを生成
RUN envsubst '$PORT' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# ファイルのパーミッションを設定
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# 必要なポートを公開
EXPOSE 80

# Supervisorを使用してNginxとPHP-FPMを管理
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
