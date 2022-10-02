<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Town;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Town>
 */
class TownFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'town_name'  => $this->faker->city(),
                'population' => rand(1000, 250000),
                'weather'    => Town::WEATHER_CLOUDY,
                'country_id' => Country::get()->first()->id,
        ];
    }
}
