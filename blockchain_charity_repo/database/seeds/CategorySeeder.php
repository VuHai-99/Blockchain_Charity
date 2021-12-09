<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert(['category_name' => 'Lương thực, thực phẩm', 'slug' => 'luong-thuc-thuc-pham']);
        DB::table('product_categories')->insert(['category_name' => 'Đồ dùng sinh hoạt', 'slug' => 'do-dung-sinh-hoat']);
        DB::table('product_categories')->insert(['category_name' => 'Dụng cụ học tập', 'slug' => 'dung-cu-hoc-tap']);
    }
}