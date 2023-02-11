<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->sentence(fake()->numberBetween(1, 3));

        return [
            'name'  => $name,
            'slug'  => Str::slug($name),
            'price' => fake()->numberBetween(1, 500),
        ];
    }
}
