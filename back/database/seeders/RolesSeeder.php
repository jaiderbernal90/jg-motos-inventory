<?php

namespace Database\Seeders;

use App\Models\setting\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                "id" => 1,
                "name" => "Super admin",
                "description" => "Rol con acceso a todos los modulos del sistema"
            ],
        ];

        foreach ($roles as $role){
            Role::create($role);
        }
    }
}
