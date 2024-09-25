# ベースイメージを指定
FROM php:8.2.10-apache

# 必要なパッケージのインストール
RUN apt update \
    && apt install -y \
        g++ \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        zip \
        zlib1g-dev \
        npm \
        nodejs \
        vim \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo \
        pdo_pgsql \
        pgsql \
        pdo_mysql

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 作業ディレクトリを設定
WORKDIR /var/www/html

# ソースをルートディレクトリにコピー（パスを確認）
COPY ./src /var/www/html

# Apacheの設定ファイルをコピー（パスを確認）
COPY ./docker/shop/apache/default.conf /etc/apache2/sites-enabled/000-default.conf

# php.iniを設定（パスを確認）
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

# Composerで依存関係をインストール
RUN composer install --no-dev --optimize-autoloader

# Laravelのアプリケーションキーを生成
RUN php artisan key:generate

# マイグレーションを実行
RUN php artisan migrate --force

# Laravelのキャッシュとログフォルダに書き込み権限を設定
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ポートのエクスポート
EXPOSE 80

# Apacheのrewriteモジュールを有効化
RUN a2enmod rewrite

# Apacheを起動
CMD ["apache2-foreground"]
