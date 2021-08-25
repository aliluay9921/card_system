<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //        $this->call([AdsTableSeeder::class]);
        $this->call([AmountsTableSeeder::class]);
        $this->call([CardsTableSeeder::class]);
        $this->call([CitiesTableSeeder::class]);
        $this->call([CompaniesTableSeeder::class]);
        $this->call([PermissionsSeeder::class]);
        $this->call([OrderTypesTableSeeder::class]);
        $this->call([UsersTableSeeder::class]);
    }
}