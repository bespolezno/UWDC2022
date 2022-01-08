<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Competitor 1',
            'email' => 'competitor1@skill17.com',
            'password' => Hash::make('demopass1'),
        ]);

        User::create([
            'name' => 'Competitor 2',
            'email' => 'competitor2@skill17.com',
            'password' => Hash::make('demopass2'),
        ]);
    }
}
