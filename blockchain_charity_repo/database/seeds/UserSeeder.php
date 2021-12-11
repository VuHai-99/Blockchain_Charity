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
            'user_address' => '3131231fsfssâc',
            'email' => 'thienpham12d@gmail.com',
            'name' => "Phạm Văn Thiện",
            'password' => bcrypt(11111111),
            'private_key' => '424242rfdfdgeheg2234241421',
            'home_address' => '422rwefdfsdf',
            'phone' => '3112414214',
            'wallet_type' => 0,
            'role' => 0,
            'amount_of_money' => 100000000,
        ]);
    }
}