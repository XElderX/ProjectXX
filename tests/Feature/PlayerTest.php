<?php

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_player_in_database()
    {
       Player::factory()->create(['first_name' => 'Harikas']);
       
        $this->assertDatabaseHas('players', [
            'first_name' => 'Harikas'
          
        ]);
    }

    public function test_create_10_players_and_check_avg_from_database()
    {
       Player::factory()->count(10)->create();


       
       
        $this->assertDatabaseHas('players', [
            'first_name' => 'Harikas'
          
        ]);
    }
}
