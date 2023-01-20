<?php

namespace Database\Seeders;

use App\Models\ModuleForRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulesForRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulesForRoles = [
            [
                "id" => 1,
                "module_id" => 1,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 2,
                "module_id" => 2,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 3,
                "module_id" => 3,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 4,
                "module_id" => 4,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 5,
                "module_id" => 5,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 6,
                "module_id" => 6,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 7,
                "module_id" => 7,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 8,
                "module_id" => 8,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 9,
                "module_id" => 9,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ],
            [
                "id" => 10,
                "module_id" => 10,
                "role_id" => 1,
                "has_admin" => 1,
                "selected" => 1
            ]
        ];

        foreach ($modulesForRoles as $moduleForRole){
            ModuleForRole::create($moduleForRole);
        }
    }
}
