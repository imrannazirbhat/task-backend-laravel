
## Setup

composer update
composer install
npm install
rename .env.example as .env
create database with name set for DB_DATABASE parameter in .env
php artisan db:seed --class=ConfigurationSeeder
php artisan serve