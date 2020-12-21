<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->word(),
            'picture' => $this->faker->image('public/storage/images/products', 640,480, 'technics',false),
            'price' => $this->faker->numberBetween($min = 15, $max = 40),
            'stock' => $this->faker->numberBetween($min = 5, $max = 50),
        ];
    }
}
