<?php

use Illuminate\Database\Seeder;

class OrderTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_types')->insert([
            [
                'id' => 1,
                'name' => "zaincash",
                'name_ar' => "زين كاش",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 2,
                'name' => "asiahawala",
                'name_ar' => "اسيا حواله",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);


    }
}
