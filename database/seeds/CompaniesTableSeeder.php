<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([

            [
                'id' => 1,
                'name' => "زين",
                'active' => 1,
                'color' => "#000000",
                'avatar' => "zain_avatar.jpg",
                'cover' => "zain_cover.png",
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 2,
                'name' => "اسياسيل",
                'active' => 1,
                'color' => "#CC1318",
                'cover' => "asiacell_cover.png",
                'avatar' => "asiacell_avatar.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => "كورك",
                'active' => 1,
                'color' => "#0177C1",
                'avatar' => "korek_avatar.jpg",
                'cover' => "korek_cover.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 4,
                'name' => "الاخرى",
                'active' => 1,
                'color' => "#242A38",
                'cover' => "cards_cover.png",
                'avatar' => "cards_cover.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
