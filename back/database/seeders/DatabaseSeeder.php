<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypesDocumentsSeeder::class);
        $this->call(TypesPersonsSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(PaymentMethodsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModulesForRolesSeeder::class);
        $this->call(LocalsSeeder::class);
    }
}
