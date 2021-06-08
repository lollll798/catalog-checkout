<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Demo',
            'email' => 'demo@gmail.com',
            'password' => bcrypt('demo'),
        ]);
        DB::table('users')->insert([
            'name' => 'Demo2',
            'email' => 'demo2@gmail.com',
            'password' => bcrypt('demo'),
        ]);
    }
}
