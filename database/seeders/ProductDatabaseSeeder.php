<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductDatabaseSeeder extends Seeder
{
  
    protected $model = Product::class;


    public function run()
    {
        \App\Models\Product::factory()->count(30)->create(); 

    }
}
