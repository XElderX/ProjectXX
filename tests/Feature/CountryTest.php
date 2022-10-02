<?php

namespace Tests\Feature;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_country_in_database()
    {
       Country::factory()->create([
        'country'      => 'Lithuania',
        'population' => 2400111,
    ]);

        $this->assertDatabaseHas('countries', [
        'country'      => 'Lithuania',
        'population' => 2400111,
        ]);
    }
}
