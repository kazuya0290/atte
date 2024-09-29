アプリケーション名
Atte勤怠管理システム
登録したユーザーが各ボタンを押して、勤務開始・終了時間、休憩開始・終了時間を記録できる勤怠管理アプリケーションです。
1日の勤務時間や休憩時間をリアルタイムで記録し、日ごとの勤務時間を確認できます。
日付が変わると、自動的に翌日の勤務に切り替わります。

基本機能
ログイン後、「勤務開始」ボタンのみが押せる状態になります。
勤務開始後、「休憩開始」および「勤務終了」ボタンが使用可能になります。
休憩は1日に何度でも取ることができ、休憩時間は手動で分単位で設定可能です。
過去の勤務時間もカレンダーを使用して確認可能です。
画面一覧
<center><b>ホーム画面</b></center> ![ホーム画面](https://github.com/user-attachments/assets/e6f2e042-9e6f-4394-93b7-072780848120) <center><b>タイマー画面</b></center> ![タイマー画面](https://github.com/user-attachments/assets/9adff991-07b2-4e72-ad24-ccbb79c12c31) <center><b>ログイン画面</b></center> ![ログイン画面](https://github.com/user-attachments/assets/c0c4911a-7209-4fb4-a780-a020dee84018) <center><b>会員登録画面</b></center> ![会員登録画面](https://github.com/user-attachments/assets/53d94cc5-247f-4bdc-8462-2aed207b5fa0) <center><b>日付一覧画面</b></center> ![日付一覧画面](https://github.com/user-attachments/assets/172e7ad9-9ecf-4be0-aea1-4acbdae60901)
作成した目的
新規事業を立ち上げた企業向けの勤怠管理システムとして開発しました。
このアプリを通じて、労務管理だけでなく、人事評価にも役立てることが可能です。

アプリケーションURL
開発環境: http://localhost/
本番環境: https://atte-dves.onrender.com
※ Dockerfile、default.conf、docker-compose.ymlファイルは、開発環境と本番環境のコードに分けて記載されています。本番環境のコードはコメントアウトされています。

他のリポジトリ
git@github.com
/atte.git
→ 勤怠管理システム、認証機能を含むリポジトリです。

機能一覧
ログイン機能
会員登録機能
勤怠管理機能
勤怠履歴確認機能・カレンダー機能
使用技術 (実行環境)
Laravel Framework 8.83.8
PHP 7.4.9
JavaScript
MySQL: php artisan migrate によるマイグレーション
テーブル図


ER図


環境構築
Dockerのビルド
リポジトリをクローン
bash
コードをコピーする
git clone git@github.com:kazuya0290/atte.git
Dockerデスクトップを立ち上げ、作成したコンテナを起動する。
コンテナの起動と再ビルド
bash
コードをコピーする
docker-compose up -d --build
Laravel環境構築
Dockerコンテナに入る
bash
コードをコピーする
docker-compose exec php bash
Composerのインストール
bash
コードをコピーする
composer install
.env.example ファイルを .env に変更、または新たに .env ファイルを作成
.env に以下の環境変数を追加
env
コードをコピーする
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
アプリケーションキーの生成
bash
コードをコピーする
php artisan key:generate
マイグレーションの実行
bash
コードをコピーする
php artisan migrate
シーディングの実行
bash
コードをコピーする
php artisan db:seed
URL
開発環境: http://localhost/
phpMyAdmin: http://localhost:8080/
