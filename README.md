# flea_market

## 環境構築

Dockerビルド

<<<<<<< HEAD
1. git clone https://github.com/tsugumi-0406/flea_market<br>
2. docker-compose up -d --build
=======
1.git clone https://github.com/tsugumi-0406/flea_market<br>
2.docker-compose up -d --build
>>>>>>> 0b6f85b1e1a08e8136d131419cea8762b8587930

Laravel 環境構築

1. docker-compose exec php bash
2. composer install
3. .env.example ファイルから.envを作成する
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed
7. php artisan storage:link

## 使用技術
・PHP 8.1  
.Laravel 8.83.29  
.MySQL 8.0.26  

## URL
・開発環境 : http://localhost/products<br>
・phpMyAdmin : http://localhost:8080/  
 PHP 8.1<br>
 Laravel 8.83.29<br>
 MySQL 8.0.26

## URL
・開発環境 : http://localhost/products<br>
・phpMyAdmin : http://localhost:8080/
