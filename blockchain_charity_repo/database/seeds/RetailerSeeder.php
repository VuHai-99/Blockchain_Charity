<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RetailerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('retailer_information')->insert([
            'retail_address' => 'abcdefgh12345',
            'retail_name' => 'K-Mart',
            'email' => 'kmart@gmail.com',
            'password' => bcrypt(11111111),
            'brief_infor' => 'Chuỗi siêu thị trải dài khắp các tỉnh thành trên cả nước',
            'hot_line' => '1900.8198',
        ]);
    }
}