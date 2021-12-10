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
        DB::table('authority_information')->insert([
            'authority_address' => '3131231fsfs',
            'email' => 'authority@gmail.com',
            'password' => bcrypt(11111111),
            'authority_local_name' => 'Hải Dương',
            'authority_location_post_code' => 34
        ]);
    }
}