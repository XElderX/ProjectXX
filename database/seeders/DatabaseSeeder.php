<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder as SeedersUserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SeedersUserSeeder::class,
            CountriesTableSeeder::class,
            TownsTableSeeder::class,
            NamesTableSeeder::class,
            SurnamesTableSeeder::class
        ]);
    }
}
