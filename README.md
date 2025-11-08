step clone : 
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

menjalankan file :
npm run dev
php artisan serve
