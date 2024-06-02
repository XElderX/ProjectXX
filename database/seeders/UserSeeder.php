<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use BinaryCabin\LaravelUUID\Traits\HasUUID;

class UserSeeder extends Seeder
{
    use HasUUID;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'uuid'                 => $this->generateUUID(),
            'username'             => 'master',
            'email'                => 'admin@admin.com',
            'password'             => Hash::make('qwertyui123'),
            'role'                 => User::ROLE_ADMIN,
            'disabled'             => false,
            'first_name'           => 'admin',
            'last_name'            => 'admin',
            'created_at'           => now(),
            'updated_at'           => now()
        ]);
    }
}
