<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'demo_user',
            'username' => 'demo_user',
            'email' => 'demo_user@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
