<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
                'name' => 'Admin',
                'user_name' => 'admin@admin',
                'password' => Hash::make('secret!@#'),
                'created_at' => now(),
                'activate_at' => now(),
                'updated_at' => now()
            ]);
        $user->assignRole('super-admin');
    }
}