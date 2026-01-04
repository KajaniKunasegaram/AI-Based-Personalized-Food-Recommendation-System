<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 1; $i <= 10; $i++) {
            DB::table('tbl_sub_categories')->insert([
                'cat_id' => rand(1, 10), // category FK
                'sub_cat_name' => 'Sub Category ' . $i,
                'sub_cat_description' => 'Sub description ' . $i,
                'sub_cat_image' => 'images/default/sub_category.jpg',
                'sub_cat_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
