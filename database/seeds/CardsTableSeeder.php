<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 10) as $index) {
            $faker = Faker::create();

            DB::table('cards')->insert([
                'id' => $index,
                'amount_id' => $faker->numberBetween(1, 7),
                'company_id' => $faker->numberBetween(1, 3),
                'city_id' => $faker->numberBetween(1, 18),
                'key' => $faker->numberBetween(1000000, 10000000),
                'used' => $faker->numberBetween(0, 1),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}