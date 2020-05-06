<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert([
                'name' => 'Ardli Firman Maulana',
                'email' => 'ardlifirman17@gmail.com',
                'password' => Hash::make('ardlifirman'),
                'api_token' => env('APP_API_KEY')
            ]);
    }
}
