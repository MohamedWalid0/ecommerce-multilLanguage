<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CategoryDatabaseSeeder extends Seeder
{
  
    protected $model = Category::class;


    public function run()
    {
        // factory(App\Models\Category::class, 30)->create();
        \App\Models\Category::factory()->count(30)->create(); 

        // factory(Category::class, 20)->create();

    }
}
