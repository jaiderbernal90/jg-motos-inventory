<?php

namespace Database\Seeders;

use App\Models\Local;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locals = [
            [
                "id" => 1,
                "code" => 01,
                "name" => "JG MOTOS",
                "nit" => "16188850-1",
                "cellphone" => "3212081405",
                "department" => "Cundinamarca",
                "city" => "Villeta",
                "direction" => "Calle 6 #5-52",
                "logo" => "http://localhost:8000/storage/16710249106399d10ea93f8.jpg"
            ],
            [
                "id" => 2,
                "code" => 02,
                "name" => "JCS MOTOS",
                "nit" => "16188850-1",
                "cellphone" => "3212081405",
                "department" => "Cundinamarca",
                "city" => "Insp. La Magdalena",
                "direction" => "Calle 4 #6-32",
                "logo" => "http://localhost:8000/storage/16710249106399d10ea93f8.jpg"
            ]
        ];

        foreach ($locals as $local){
            Local::create($local);
        }
    }
}
