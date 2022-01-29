<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'sub_title' => $this->faker->text,
            'description' => $this->faker->sentence(50),
            'price' => $this->faker->randomFloat(2, 999, 3999),
            'image' => '/assets/artworks/' . $this->faker->randomElement(['akoniton.jpg', 'hera.jpg', 'poseidon.jpg', 'cheimonas-orig.jpg']),
            'is_sold' => $this->faker->numberBetween(0 ,1),
            'is_draft' => $this->faker->numberBetween(0, 1),
        ];
    }
}
