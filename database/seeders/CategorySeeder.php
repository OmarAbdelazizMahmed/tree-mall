<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Women', 'slug' => 'Women', 'code' =>'W' , 'image' => 'images/categories/women.jpeg'],
            ['name' => 'Men', 'slug' => 'men', 'code' =>'M', 'image' => 'images/categories/men.jpeg'],
            ['name' => 'Kids', 'slug' => 'kids', 'code' =>'K', 'image' => 'images/categories/kids.jpeg'],
            ['name' => 'Home Goods', 'slug' => 'homegoods', 'code' =>'HG', 'image' => 'images/categories/homegoods.jpeg'],
        ];

        foreach($categories as $category)
        {
            Category::create($category);
        }
    }
}
