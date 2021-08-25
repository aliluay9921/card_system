<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view cards']);
        Permission::create(['name' => 'add cards']);
        Permission::create(['name' => 'edit cards']);

        Permission::create(['name' => 'view amounts']);
        Permission::create(['name' => 'add amounts']);
        Permission::create(['name' => 'edit amounts']);

        Permission::create(['name' => 'view cities']);
        Permission::create(['name' => 'add cities']);
        Permission::create(['name' => 'edit cities']);


        Permission::create(['name' => 'view ads']);
        Permission::create(['name' => 'add ads']);
        Permission::create(['name' => 'edit ads']);


        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'edit users']);

        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'add companies']);
        Permission::create(['name' => 'edit companies']);

        Permission::create(['name' => 'view profile']);
        Permission::create(['name' => 'add profile']);
        Permission::create(['name' => 'edit profile']);

        $role3 = Role::create(['name' => 'super-admin']);


        $role2 = Role::create(['name' => 'user']);
        $role2->givePermissionTo('view profile');
        $role2->givePermissionTo('add profile');
        $role2->givePermissionTo('edit profile');


        $role1 = Role::create(['name' => 'viewer']);
        $role1->givePermissionTo('view profile');
        $role1->givePermissionTo('view cards');
        $role1->givePermissionTo('view amounts');
        $role1->givePermissionTo('view cities');
        $role1->givePermissionTo('view ads');
        $role1->givePermissionTo('view users');
        $role1->givePermissionTo('view companies');
        $role1->givePermissionTo('view profile');

        $role4 = Role::create(['name' => 'admin']);



    }
}
