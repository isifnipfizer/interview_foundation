<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ioannis',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'api_token' => Str::random(20),
        ]);
    }
}
