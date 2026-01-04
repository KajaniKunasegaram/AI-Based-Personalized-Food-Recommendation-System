<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 1; $i <= 10; $i++) {
            DB::table('tbl_delivery')->insert([
                'postcode' => '4000' . $i,
                'delivery_type' => ($i % 2 == 0) ? 'free' : 'charge',
                'delivery_charge' => ($i % 2 == 0) ? null : 150,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
