#!/bin/sh

# Laravelのキー生成とキャッシュクリアを実行
php artisan key:generate
php artisan config:cache
php artisan view:cache

# マイグレーションの実行
php artisan migrate