<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $response = $client->request('GET', 'https://fakerapi.it/api/v1/books?_quantity=100');
        $books_records = json_decode($response->getBody(), true);
        Book::insert($books_records['data']);
    }
}
