<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Insert or Update 3 products
        DB::table('products')->updateOrInsert(
            ['name' => 'Orange Paint Card'], // Check if the product with the same name exists
            [
                'description' => 'Some quick example text to build on the card title and make up the bulk of the card content.',
                'price' => 50,
                'image' => 'upload/products/2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('products')->updateOrInsert(
            ['name' => 'Tea Cup art'], // Check if the product with the same name exists
            [
                'description' => 'Some quick example text to build on the card title and make up the bulk of the card content.',
                'price' => 35,
                'image' => 'upload/products/4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('products')->updateOrInsert(
            ['name' => 'Leg tattoo paint'], // Check if the product with the same name exists
            [
                'description' => 'Some quick example text to build on the card title and make up the bulk of the card content.',
                'price' => 65,
                'image' => 'upload/products/5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}

