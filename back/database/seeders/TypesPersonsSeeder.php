<?php

namespace Database\Seeders;

use App\Models\setting\TypePerson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesPersonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typesPersons = [
            [
                "id" => 1,
                "name" => "Persona natural"
            ],
            [
                "id" => 2,
                "name" => "Persona jurídica"
            ]
        ];


        foreach ($typesPersons as $typePerson){
            TypePerson::create($typePerson);
        }
    }
}
