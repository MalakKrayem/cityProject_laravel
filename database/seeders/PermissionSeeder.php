<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /******************** Admin Permissions ************************/
        Permission::create(["name"=>'Create-Role',"guard_name"=>"admin"]);
        Permission::create(["name" => 'Read-Roles', "guard_name" => "admin"]);
        Permission::create(["name" => 'Update-Role', "guard_name" => "admin"]);
        Permission::create(["name" => 'Delete-Role', "guard_name" => "admin"]);

        Permission::create(["name" => 'Create-Permission', "guard_name" => "admin"]);
        Permission::create(["name" => 'Read-Permissions', "guard_name" => "admin"]);
        Permission::create(["name" => 'Update-Permission', "guard_name" => "admin"]);
        Permission::create(["name" => 'Delete-Permission', "guard_name" => "admin"]);

        Permission::create(["name" => 'Create-City', "guard_name" => "admin"]);
        Permission::create(["name" => 'Read-Cities', "guard_name" => "admin"]);
        Permission::create(["name" => 'Update-City', "guard_name" => "admin"]);
        Permission::create(["name" => 'Delete-City', "guard_name" => "admin"]);

        Permission::create(["name" => 'Create-User', "guard_name" => "admin"]);
        Permission::create(["name" => 'Read-Users', "guard_name" => "admin"]);
        Permission::create(["name" => 'Update-User', "guard_name" => "admin"]);
        Permission::create(["name" => 'Delete-User', "guard_name" => "admin"]);

        Permission::create(["name" => 'Create-Admin', "guard_name" => "admin"]);
        Permission::create(["name" => 'Read-Admins', "guard_name" => "admin"]);
        Permission::create(["name" => 'Update-Admin', "guard_name" => "admin"]);
        Permission::create(["name" => 'Delete-Admin', "guard_name" => "admin"]);

        /******************** User Permissions ************************/
        Permission::create(["name" => 'Read-Users', "guard_name" => "web"]);
        Permission::create(["name" => 'Read-Cities', "guard_name" => "web"]);



    }
}
