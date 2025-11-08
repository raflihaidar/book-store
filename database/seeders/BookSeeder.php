<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'price' => 10.99,
            'stock' => 50,
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'price' => 8.99,
            'stock' => 100,
        ]);

        Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'price' => 12.99,
            'stock' => 75,
        ]);
    }
}
