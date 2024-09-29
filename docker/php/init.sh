#!/bin/sh

# Laravelのキー生成とキャッシュクリアを実行
php artisan key:generate || { echo "key:generate failed"; exit 1; }
php artisan config:cache || { echo "config:cache failed"; exit 1; }
php artisan view:cache || { echo "view:cache failed"; exit 1; }

# データベースに接続できるか確認
if ! mysqladmin ping -h mysql -u laravel_user -p"laravel_pass" --silent; then
  echo "Database is not reachable, exiting."
  exit 1
fi

# マイグレーションの実行
php artisan migrate --force || { echo "migrate failed"; exit 1; }