<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class
        ]);

        Product::factory(40)->state(new Sequence(
            fn($sequence) => [
                'name' => 'sample product '.$sequence->index
            ]
        ))->state(new Sequence(
            ['price' => 100000],
            ['price' => 125000],
            ['price' => 150000]
        ))->state(new Sequence(
            ['weight' => 500],
            ['weight' => 700]
        ))->state(new Sequence(
            [
                'brand' => 'product-ready',
                'status' => 'available'
            ],
            [
                'brand' => 'product-ready',
                'status' => 'preorder'
            ],
            [
                'brand' => 'barang-unik',
                'status' => 'available',
            ],
            [
                'brand' => 'barang-unik',
                'status' => 'preorder',
            ]
        ))
        ->create();
    }
}
