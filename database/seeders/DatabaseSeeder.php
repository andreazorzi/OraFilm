<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $users = User::factory(100)->create();
        
        // User::create([
        //     'username' => 'admin',
        //     'name' => 'Admin',
        //     'email' => 'admin@locahost',
        //     'password' => bcrypt('password'),
        //     'type' => 'admin',
        //     'groups' => ['administrator', 'WebDev'],
        //     'enabled' => true,
        // ]);
    }
}
