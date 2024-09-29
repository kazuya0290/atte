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

# PHPのベースイメージを使用
FROM php:8.0-fpm

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# COMPOSER_ALLOW_SUPERUSERを設定
ENV COMPOSER_ALLOW_SUPERUSER=1

# 作業ディレクトリを指定
WORKDIR /var/www

# プロジェクトファイルをコンテナにコピー
COPY ./src /var/www 
COPY ./src/.env.example /var/www/.env
# Laravelプロジェクトに必要な権限を設定
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www

# Composerのキャッシュをクリアしてインストールを実行
RUN composer clear-cache && \
    composer install --no-dev --optimize-autoloader || { echo 'Composer install failed'; exit 1; }

# init.shをコンテナにコピーして実行権限を付与
COPY ./docker/php/init.sh /usr/local/bin/init.sh
RUN chmod +x /usr/local/bin/init.sh

# ポートを開放
EXPOSE ${PORT:-80}

# アプリケーションの初期化を行うスクリプトを実行
CMD ["/usr/local/bin/init.sh"]
