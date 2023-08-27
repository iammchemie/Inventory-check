<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email_verified_at' => time(),
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'roleId' => 1,
        ]);
        User::create([
            'name' => 'Operator',
            'username' => 'operator',
            'email_verified_at' => time(),
            'email' => 'operator@gmail.com',
            'password' => bcrypt('operator'),
            'roleId' => 2,
        ]);
        User::create([
            'name' => 'Guest',
            'username' => 'guest',
            'email_verified_at' => time(),
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
            'roleId' => 3,
        ]);
    }
}
