<?php

namespace Database\Seeders;

use App\Models\Category;
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
            $category = Category::where('code', 'M')->first();
            Product::create([
                'name' => 'Men ' . $i,
                'slug' => 'men-' . $i,
                'details' => 'men ' . $i . ' details',
                'code' => $category->code .'-00'.$i,
                'description' => 'men ' . $i . ' description',
                'price' => rand(10, 100),
                'main_image' => 'products/main_images/product.png',
                'alt_images' => ['products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png'],
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
                'quantity' => rand(0, 100),
            ])->categories()->attach($category);
        }

        // create 12 products
        for ($i = 0; $i < 12; $i++) {
            $category = Category::where('code', 'W')->first();

            Product::create([
                'name' => 'women ' . $i,
                'slug' => 'women-' . $i,
                'details' => 'women ' . $i . ' details',
                'code' => $category->code .'-00'.$i,
                'description' => 'women ' . $i . ' description',
                'price' => rand(10, 100),
                'main_image' => 'products/main_images/product.png',
                'alt_images' => ['products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png'],
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
                'quantity' => rand(0, 100),
            ])->categories()->attach($category);
        }

        // create 12 products
        for ($i = 0; $i < 12; $i++) {
            $category = Category::where('code', 'K')->first();

            Product::create([
                'name' => 'kids ' . $i,
                'slug' => 'kids-' . $i,
                'details' => 'kids ' . $i . ' details',
                'code' => $category->code .'-00'.$i,
                'description' => 'kids ' . $i . ' description',
                'price' => rand(10, 100),
                'main_image' => 'products/main_images/product.png',
                'alt_images' => ['products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png'],
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
                'quantity' => rand(0, 100),
            ])->categories()->attach($category);
        }

        // create 12 products
        for ($i = 0; $i < 12; $i++) {
            $category = Category::where('code', 'HG')->first();

            Product::create([
                'name' => 'Home F ' . $i,
                'slug' => 'kids-' . $i,
                'details' => 'kids ' . $i . ' details',
                'code' => $category->code .'-00'.$i,
                'description' => 'kids ' . $i . ' description',
                'price' => rand(10, 100),
                'main_image' => 'products/main_images/product.png',
                'alt_images' => ['products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png', 'products/alt_images/product.png'],
                'featured' => rand(0, 1) == 1 ? true : false,
                'active' => rand(0, 1) == 1 ? true : false,
                'quantity' => rand(0, 100),
            ])->categories()->attach($category);
        }
    }
}
