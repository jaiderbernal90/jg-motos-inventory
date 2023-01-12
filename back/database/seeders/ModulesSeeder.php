<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            [
                "id" => 1,
                "name" => "Roles"
            ],
            [
                "id" => 2,
                "name" => "Usuarios"
            ],
            [
                "id" => 3,
                "name" => "Clientes"
            ],
            [
                "id" => 4,
                "name" => "Proveedores"
            ],
            [
                "id" => 5,
                "name" => "Categorías"
            ],
            [
                "id" => 6,
                "name" => "Marcas"
            ],
            [
                "id" => 7,
                "name" => "Local"
            ],
            [
                "id" => 8,
                "name" => "Productos"
            ],
            [
                "id" => 9,
                "name" => "Ventas"
            ]
        ];


        foreach ($modules as $module){
            Module::create($module);
        }
    }
}
