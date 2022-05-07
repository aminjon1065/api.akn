<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $arrayPermissionsName = [
//            Users
            'access users',
            'create document',
            'update document',
            'delete document',
            'create mail',
        ];

        $permissions = collect($arrayPermissionsName)->map(function ($permission) {
            return ["name" => $permission, "guard_name" => "web"];
        });
        Permission::insert($permissions->toArray());
        Role::create(["name" => "admin"])->givePermissionTo(Permission::all());
        Role::create(["name" => "users"])->givePermissionTo(null);
        User::find(1)->assignRole('admin');
    }
}
