<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('tbl_categories')->insert([
                'cat_name' => 'Category ' . $i,
                'cat_description' => 'Description for category ' . $i,
                'cat_image' => 'images/default/category.jpg',
                'cat_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
