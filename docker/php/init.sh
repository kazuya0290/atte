#!/bin/sh

# Laravelのキー生成とキャッシュクリアを実行
php artisan key:generate || { echo "key:generate failed"; exit 1; }
php artisan config:cache || { echo "config:cache failed"; exit 1; }
php artisan view:cache || { echo "view:cache failed"; exit 1; }

# データベースに接続できるか確認
until php -r 'new PDO("mysql:host=mysql;dbname=laravel_db", "laravel_user", "laravel_pass");' ; do
  echo "Waiting for database connection..."
  sleep 5
done

# マイグレーションの実行
php artisan migrate --force || { echo "migrate failed"; exit 1; }