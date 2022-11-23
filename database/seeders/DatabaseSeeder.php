<?php

namespace Database\Seeders;

use Database\Seeders\DesignationSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\DivisionSeeder;
use Database\Seeders\FieldTypeSeeder;
use Database\Seeders\UnitTypeSeeder;
use Database\Seeders\UpazilaSeeder;
use Database\Seeders\UserSeeder;
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
        $arr = [
            UserSeeder::class,
            UnitTypeSeeder::class,
            FieldTypeSeeder::class,
            DesignationSeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
            UpazilaSeeder::class,
        ];

        $this->call($arr);
    }
}
