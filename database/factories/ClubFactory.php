<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Country;
use App\Models\Town;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Club>
 */
class ClubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();

        $country = (count(Country::all()) < 1) 
        ? $country = Country::factory()->create()
        : $country = Country::all()
        ->random();

        $town = (!Town::all()
            ->where('country_id', $country->id)
            ->first()) 
            ? $town = Town::factory()
            ->create(['country_id' => $country->id]) 
            : $town = Town::all()
            ->where('country_id', $country->id)
            ->first();

        return [

                'club_name'          => $this->faker->title(),
                'club_rating_points' => rand(0, 25000),
                'supporters'         => rand(100, 15000),
                'supporters_mood'    => Club::SUPPORTERS_MOOD[(rand(1, count(Club::SUPPORTERS_MOOD)))-1],
                'budget'             => rand(0, 1500000), 
                'country_id'         => $country->id,
                'town_id'            => $town->id,
                'user_id'            => $user->id,
        ];
    }
}
