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


// INSERT INTO tbl_delivery (postcode, delivery_type, delivery_charge, created_at, updated_at) VALUES
// ('W1', 'charge', 5.99, NOW(), NOW()),
// ('W2', 'charge', 5.99, NOW(), NOW()),
// ('W3', 'charge', 5.99, NOW(), NOW()),
// ('W4', 'charge', 5.99, NOW(), NOW()),
// ('NW1', 'charge', 5.99, NOW(), NOW()),
// ('NW2', 'charge', 5.99, NOW(), NOW()),
// ('NW3', 'charge', 5.99, NOW(), NOW()),
// ('NW4', 'charge', 5.99, NOW(), NOW()),
// ('NW6', 'charge', 5.99, NOW(), NOW()),
// ('NW8', 'charge', 5.99, NOW(), NOW()),
// ('SW1', 'charge', 5.99, NOW(), NOW()),
// ('SW2', 'charge', 5.99, NOW(), NOW()),
// ('SW3', 'charge', 5.99, NOW(), NOW()),
// ('SW6', 'charge', 5.99, NOW(), NOW()),
// ('SW7', 'charge', 5.99, NOW(), NOW()),
// ('SW11', 'charge', 5.99, NOW(), NOW()),
// ('N1', 'charge', 5.99, NOW(), NOW()),
// ('N2', 'charge', 5.99, NOW(), NOW()),
// ('N3', 'charge', 5.99, NOW(), NOW()),
// ('N5', 'charge', 5.99, NOW(), NOW()),
// ('E1', 'charge', 5.99, NOW(), NOW()),
// ('E2', 'charge', 5.99, NOW(), NOW()),
// ('E3', 'charge', 5.99, NOW(), NOW()),
// ('E6', 'charge', 5.99, NOW(), NOW()),
// ('SE1', 'charge', 5.99, NOW(), NOW()),
// ('SE5', 'charge', 5.99, NOW(), NOW()),
// ('SE10', 'charge', 5.99, NOW(), NOW()),
// ('HA0', 'charge', 5.99, NOW(), NOW()),
// ('HA1', 'charge', 5.99, NOW(), NOW()),
// ('HA3', 'charge', 5.99, NOW(), NOW()),
// ('UB1', 'charge', 5.99, NOW(), NOW()),
// ('UB2', 'charge', 5.99, NOW(), NOW()),
// ('UB3', 'charge', 5.99, NOW(), NOW()),
// ('EN1', 'charge', 5.99, NOW(), NOW()),
// ('EN2', 'charge', 5.99, NOW(), NOW()),
// ('WD6', 'charge', 5.99, NOW(), NOW()),
// ('WD7', 'charge', 5.99, NOW(), NOW()),
// ('CR0', 'charge', 5.99, NOW(), NOW()),
// ('SM1', 'charge', 5.99, NOW(), NOW());
