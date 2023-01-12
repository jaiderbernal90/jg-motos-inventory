<?php

namespace Database\Seeders;

use App\Models\setting\TypeDocument;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typesDocuments = [
            [
                "id" => 1,
                "name" => "Cédula de ciudadanía",
                "prefix" => "CC"
            ],
            [
                "id" => 2,
                "name" => "Cédula de extranjeria",
                "prefix" => "CE"
            ],
            [
                "id" => 3,
                "name" => "NIT",
                "prefix" => "NIT"
            ],
            [
                "id" => 4,
                "name" => "Tarjeta de identidad",
                "prefix" => "TI"
            ],
            [
                "id" => 5,
                "name" => "Pasaporte",
                "prefix" => "PSP"
            ],
        ];


        foreach ($typesDocuments as $typeDocument){
            TypeDocument::create($typeDocument);
        }
    }
}
