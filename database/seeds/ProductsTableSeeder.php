<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'title' => 'Pizza 1',
            'description' => 'Perfect pizza
             number 1',
            'cost' => "100",
            'image' => "pizza1.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'title' => 'Pizza 2',
            'description' => 'Perfect pizza
             number 2',
            'cost' => "200",
            'image' => "pizza2.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'title' => 'Pizza 3',
            'description' => 'Perfect pizza
             number 3',
            'cost' => "300",
            'image' => "pizza3.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'title' => 'Pizza 4',
            'description' => 'Perfect pizza
             number 4',
            'cost' => "400",
            'image' => "pizza4.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'title' => 'Pizza 5',
            'description' => 'Perfect pizza
             number 5',
            'cost' => "500",
            'image' => "pizza1.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'title' => 'Pizza 6',
            'description' => 'Perfect pizza
             number 6',
            'cost' => "600",
            'image' => "pizza2.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'title' => 'Pizza 7',
            'description' => 'Perfect pizza
             number 7',
            'cost' => "700",
            'image' => "pizza3.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'title' => 'Pizza 8',
            'description' => 'Perfect pizza
             number 8',
            'cost' => "100",
            'image' => "pizza4.jpg",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
