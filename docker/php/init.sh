#!/bin/sh

# Laravelのキー生成とキャッシュクリアを実行
# .envファイルがなくても環境変数が設定されていれば問題ないため、確認を省略
php artisan key:generate || { echo "key:generate failed"; exit 1; }
php artisan config:cache || { echo "config:cache failed"; exit 1; }
php artisan view:cache || { echo "view:cache failed"; exit 1; }

# マイグレーションの実行
php artisan migrate --force || { echo "migrate failed"; exit 1; }