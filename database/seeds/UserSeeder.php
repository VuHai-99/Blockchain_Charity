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
        DB::table('admins')->insert([
            'admin_address' => '3131231fsfs',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(11111111),
            'private_key' => 'abc123456'
        ]);
    }
}