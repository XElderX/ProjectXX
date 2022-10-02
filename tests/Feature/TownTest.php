<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Town;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TownTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_town_in_database()
    {
        $country = Country::factory()->create([
            'country' => 'Lithuania',
            'population' => 2400111,
        ]);
        Town::factory()->create([
            'country_id' => $country->id,
        ]);
       

        $this->assertDatabaseHas('towns', [
            'country_id' => $country->id,
          
        ]);
    }
}
