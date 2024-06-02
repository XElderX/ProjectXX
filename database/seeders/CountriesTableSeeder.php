<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['country' => 'United States', 'population' => 331000000, 'flag' => 'us', 'timezone' => 'America/New_York'],
            ['country' => 'Canada', 'population' => 37700000, 'flag' => 'ca', 'timezone' => 'America/Toronto'],
            ['country' => 'United Kingdom', 'population' => 67800000, 'flag' => 'gb', 'timezone' => 'Europe/London'],
            ['country' => 'Australia', 'population' => 25600000, 'flag' => 'au', 'timezone' => 'Australia/Sydney'],
            ['country' => 'India', 'population' => 1380000000, 'flag' => 'in', 'timezone' => 'Asia/Kolkata'],
            ['country' => 'Lithuania', 'population' => 2400500, 'flag' => 'lt', 'timezone' => 'Europe/Vilnius'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'country' => $country['country'],
                'population' => $country['population'],
                'flag' => $country['flag'],
                'timezone' => $country['timezone'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
