<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'demo_user',
            'username' => 'demo_user',
            'email' => 'demo_user@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
