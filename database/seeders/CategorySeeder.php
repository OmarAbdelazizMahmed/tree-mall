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
            ['name' => 'Women', 'slug' => 'Women', 'code' =>'W'],
            ['name' => 'Men', 'slug' => 'men', 'code' =>'M'],
            ['name' => 'Kids', 'slug' => 'kids', 'code' =>'K'],
            ['name' => 'Home Goods', 'slug' => 'homegoods', 'code' =>'HG']
        ];

        foreach($categories as $category)
        {
            Category::create($category);
        }
    }
}
