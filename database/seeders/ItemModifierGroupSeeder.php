<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemModifierGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 1; $i <= 10; $i++) {
            DB::table('tbl_item_modifier_group')->insert([
                'item_id' => rand(1, 10),
                'modifier_group_id' => rand(1, 10),
            ]);
        }
    }
}
