<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('cities')->insert([
            [
                'id' => 1,
                'name' => "بغداد",
                'name_en' => "Baghdad",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => "الانبار",
                'name_en' => "Anbar",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' => 3,
                'name' => "بابل",
                'name_en' => "Bābil",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => "اربيل",
                'name_en' => "Erbil",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,

                'name' => "البصره",
                'name_en' => "Basrah",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => "دهوك",
                'name_en' => "Dohuk",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => "الديوانيه",
                'name_en' => "Diwaniya",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => "ديالى",
                'name_en' => "Diyālá",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'name' => "ذي قار",
                'name_en' => "Qar",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => "سليمانيه",
                'name_en' => "Sulaymaniyah",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'name' => "صلاح الدين",
                'name_en' => "Salah",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'name' => "كركوك",
                'name_en' => "Kirkuk",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'name' => "كربلاء",
                'name_en' => "Kerbala",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' => 14,

                'name' => "المثنى",
                'name_en' => "Muthanná",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>15,
                'name' => "ميسان",
                'name_en' => "Maysan",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>16,
                'name' => "النجف",
                'name_en' => "Najaf",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>17,
                'name' => "نينوى",
                'name_en' => "Nineveh",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>18,
                'name' => "واسط",
                'name_en' => "Wāsiţ",
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
