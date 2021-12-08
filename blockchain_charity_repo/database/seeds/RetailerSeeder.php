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
        DB::table('retailers')->insert([
            'retailer_address' => 'abcdefgh12345',
            'name' => 'K-Mart',
            'email' => 'kmart@gmail.com',
            'password' => bcrypt(11111111),
            'description' => 'Chuỗi siêu thị trải dài khắp các tỉnh thành trên cả nước',
            'phone' => '1900.8198',
        ]);

        DB::table('authorities')->insert([
            'authority_address' => 'abcdefgh12345',
            'authority_name' => 'Đoàn Văn A',
            'email' => 'authority@gmail.com',
            'password' => bcrypt(11111111),
            'authority_local_name' => 'Yên Xá',
            "authority_local_code" => 'Hà Tĩnh'
        ]);
    }
}