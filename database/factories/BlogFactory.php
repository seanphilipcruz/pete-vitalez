<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
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
            'date' => $this->faker->dateTime,
            'image' => '/assets/artworks/' . $this->faker->randomElement(['akoniton.jpg', 'hera.jpg', 'poseidon.jpg', 'cheimonas-orig.jpg']),
            'is_published' => $this->faker->numberBetween(0, 1),
        ];
    }
}
