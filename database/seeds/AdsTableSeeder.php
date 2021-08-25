<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        DB::table('ads')->insert([
            'title' => $faker->title,
            'text' => $faker->text,
            'public' => $faker->numberBetween(0, 1),
            'active' => $faker->numberBetween(0, 1),
            'image' => "",
            'url' => "https://www.youtube.com",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
