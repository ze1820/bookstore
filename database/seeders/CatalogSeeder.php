<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $authors = collect([
            'Sahar Jaber',
            'Sheikh Jafar Hammoud',
            'Mohammad Chaer',
            'Mohammad Hamza',
            'Mariam Dahoui Charara',
        ])->mapWithKeys(fn ($name) => [
            $name => Author::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            ),
        ]);

        $books = [
            ['title' => 'But Why is Prayer So Special?', 'price_cents' => 2700, 'sale_price_cents' => null, 'author' => 'Sahar Jaber'],
            ['title' => 'But Why is the Hijab so Special?', 'price_cents' => 2600, 'sale_price_cents' => null, 'author' => 'Sahar Jaber'],
            ['title' => 'Hussain: Never To Humiliation', 'price_cents' => 3600, 'sale_price_cents' => null, 'author' => 'Mohammad Hamza'],
            ['title' => 'Once Upon A Journey', 'price_cents' => 2900, 'sale_price_cents' => null, 'author' => null],
            ['title' => 'To Enter His Gardens', 'price_cents' => 4800, 'sale_price_cents' => 3200, 'author' => null],
        ];

        foreach ($books as $data) {
            $book = Book::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'price_cents' => $data['price_cents'],
                    'sale_price_cents' => $data['sale_price_cents'],
                    'is_active' => true,
                ]
            );

            if ($data['author']) {
                $book->authors()->syncWithoutDetaching([$authors[$data['author']]->id]);
            }
        }
    }
}