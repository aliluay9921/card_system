<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmountsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('amounts')->insert([
            [
                'id' => 1,
                'value' => "5000",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'value' => "10000",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 3,
                'value' => "15000",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'value' => "25000",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,

                'value' => "35000",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'value' => "50000",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'value' => "100000",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}