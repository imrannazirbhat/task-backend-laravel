
## Setup

composer update
composer install
npm install
rename .env.example as .env
php artisan db:seed --class=ConfigurationSeeder
php artisan serve