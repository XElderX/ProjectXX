<?php

namespace Tests\Feature;

use App\Models\Club;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClubTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_club_in_database()
    {
       Club::factory()->create(['club_name' => 'Gangsta FC']);
       
        $this->assertDatabaseHas('clubs', [
            'club_name' => 'Gangsta FC'
          
        ]);
    }
}
