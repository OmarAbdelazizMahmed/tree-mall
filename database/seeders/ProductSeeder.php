<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 12 products
        for ($i = 0; $i < 12; $i++) {
            Product::create([
                'name' => 'Men ' . $i,
                'slug' => 'men-' . $i,
                'details' => 'men ' . $i . ' details',
                'code' => 'men-' . $i,
                'description' => 'men ' . $i . ' description',
                'price' => rand(10, 100),
                'image' => 'default/product.png',
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
            ]);
        }

        // create 12 products
        for ($i = 0; $i < 12; $i++) {
            Product::create([
                'name' => 'women ' . $i,
                'slug' => 'women-' . $i,
                'details' => 'women ' . $i . ' details',
                'code' => 'women-' . $i,
                'description' => 'women ' . $i . ' description',
                'price' => rand(10, 100),
                'image' => 'default/product.png',
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
            ]);
        }

        // create 12 products
        for ($i = 0; $i < 12; $i++) {
            Product::create([
                'name' => 'kids ' . $i,
                'slug' => 'kids-' . $i,
                'details' => 'kids ' . $i . ' details',
                'code' => 'kids-' . $i,
                'description' => 'kids ' . $i . ' description',
                'price' => rand(10, 100),
                'image' => 'default/product.png',
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
            ]);
        }

        // create 12 products
        for ($i = 0; $i < 12; $i++) {
            Product::create([
                'name' => 'Home F ' . $i,
                'slug' => 'kids-' . $i,
                'details' => 'kids ' . $i . ' details',
                'code' => 'kids-' . $i,
                'description' => 'kids ' . $i . ' description',
                'price' => rand(10, 100),
                'image' => 'default/product.png',
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
            ]);
        }
    }
}
