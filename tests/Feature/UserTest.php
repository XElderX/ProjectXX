<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_in_database()
    {
       User::factory()->create([
        'email'      => 'user@user.com',
        'first_name' => 'Joe'
    ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@user.com',
            'first_name' => 'Joe'
        ]);
    }

    public function test_user_is_admin()
    {
        User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $this->assertDatabaseHas('users', [
            'role' => 'admin',
        ]);
    }
}

