<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubCategoryDatabaseSeeder extends Seeder
{



    public function run()
    {
  
        \App\Models\Category::factory()->count(10)->create([
            'parent_id' => $this->getRandomParentId(),
        ]); 


    }

    private function getRandomParentId()
    {
       $parent_id =  \App\Models\Category::inRandomOrder()->first();
       return $parent_id;
    }




}
