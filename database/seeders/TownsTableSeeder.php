<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TownsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $towns = [
            // United States
            ['town_name' => 'New York', 'country_id' => 1, 'population' => 8419000, 'weather' => 'cloudy'],
            ['town_name' => 'Los Angeles', 'country_id' => 1, 'population' => 3980000, 'weather' => 'cloudy'],
            ['town_name' => 'Chicago', 'country_id' => 1, 'population' => 2716000, 'weather' => 'cloudy'],

            // Canada
            ['town_name' => 'Toronto', 'country_id' => 2, 'population' => 2930000, 'weather' => 'cloudy'],
            ['town_name' => 'Vancouver', 'country_id' => 2, 'population' => 675000, 'weather' => 'cloudy'],
            ['town_name' => 'Montreal', 'country_id' => 2, 'population' => 1760000, 'weather' => 'cloudy'],

            // United Kingdom
            ['town_name' => 'London', 'country_id' => 3, 'population' => 8982000, 'weather' => 'cloudy'],
            ['town_name' => 'Manchester', 'country_id' => 3, 'population' => 553230, 'weather' => 'cloudy'],
            ['town_name' => 'Birmingham', 'country_id' => 3, 'population' => 1141816, 'weather' => 'cloudy'],

            // Australia
            ['town_name' => 'Sydney', 'country_id' => 4, 'population' => 5312000, 'weather' => 'cloudy'],
            ['town_name' => 'Melbourne', 'country_id' => 4, 'population' => 5078000, 'weather' => 'cloudy'],
            ['town_name' => 'Brisbane', 'country_id' => 4, 'population' => 2514000, 'weather' => 'cloudy'],

            // India
            ['town_name' => 'Mumbai', 'country_id' => 5, 'population' => 12442373, 'weather' => 'cloudy'],
            ['town_name' => 'Delhi', 'country_id' => 5, 'population' => 11007835, 'weather' => 'cloudy'],
            ['town_name' => 'Bangalore', 'country_id' => 5, 'population' => 8436675, 'weather' => 'cloudy'],

            // Lithuania
            ['town_name' => 'Vilnius', 'country_id' => 6, 'population' => 580020, 'weather' => 'cloudy'],
            ['town_name' => 'Kaunas', 'country_id' => 6, 'population' => 304000, 'weather' => 'cloudy'],
            ['town_name' => 'Klaipeda', 'country_id' => 6, 'population' => 152818, 'weather' => 'cloudy'],
        ];

        foreach ($towns as $town) {
            DB::table('towns')->insert([
                'town_name' => $town['town_name'],
                'country_id' => $town['country_id'],
                'population' => $town['population'],
                'weather' => $town['weather'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
