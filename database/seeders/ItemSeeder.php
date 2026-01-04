<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 1; $i <= 10; $i++) {
            DB::table('tbl_items')->insert([
                'sub_cat_id' => rand(1, 10),
                'item_name' => 'Item ' . $i,
                'item_description' => 'Item desc ' . $i,
                'item_price' => rand(100, 500),
                'item_image' => 'images/default/item.jpg',
                'item_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
