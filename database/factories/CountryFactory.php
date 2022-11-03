<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'country'    => $this->faker->country(),
                'population' => rand(20000, 10000000),
                'flag'       => "<span class=\"fi fi-gr fis\"></span>"
        ];
    }
}
