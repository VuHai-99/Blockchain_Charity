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
        DB::table('authorities')->insert([
            'authority_address' => '0x2821E40a6cddc5c217B1DFDceB587a81ee1d325d',
            'authority_name' => 'Andre',
            'email' => 'authority@gmail.com',
            'password' => bcrypt(11111111),
            'authority_local_name' => 'Hai duong',
            'authority_local_code' => '34',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}