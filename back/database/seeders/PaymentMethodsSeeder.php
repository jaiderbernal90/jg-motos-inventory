<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
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
                "name" => "Efectivo"
            ],
            [
                "id" => 2,
                "name" => "Nequi"
            ],
            [
                "id" => 3,
                "name" => "Daviplata"
            ],
            [
                "id" => 4,
                "name" => "Bancolombia"
            ],
        ];


        foreach ($modules as $module){
            PaymentMethod::create($module);
        }
    }
}
