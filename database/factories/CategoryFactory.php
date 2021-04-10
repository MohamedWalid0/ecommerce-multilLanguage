<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    
    public function definition()
    {
        return [
            
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'is_active' => $this->faker->boolean(),


        ];
    }
}