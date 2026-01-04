<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       for ($i = 1; $i <= 10; $i++) {
            DB::table('tbl_modifiers')->insert([
                'modifier_group_id' => rand(1, 10),
                'name' => 'Modifier ' . $i,
                'price' => rand(10, 100),
                'min' => 0,
                'max' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
