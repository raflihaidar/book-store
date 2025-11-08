# Book Store

## Installation

Langkah-langkah setup project:

1. Clone repository
2. Jalankan perintah berikut:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

## Running the Application

Jalankan kedua command di bawah ini (di terminal terpisah):

```bash
npm run dev
```

```bash
php artisan serve
```
