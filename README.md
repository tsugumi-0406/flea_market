# flea_market

## 環境構築

Dockerビルド

1.get clone https://github.com/tsugumi-0406/flea_market<br>
2.docker-compose up -d --build

Laravel 環境構築

1. docker-compose exec php bash
2. composer install
3. .env.example ファイルから.envを作成する
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed
7. php artisan storage:link

## 使用技術
 PHP 8.1<br>
 Laravel 8.83.29<br>
 MySQL 8.0.26

## URL
・開発環境 : http://localhost/products<br>
・phpMyAdmin : http://localhost:8080/
