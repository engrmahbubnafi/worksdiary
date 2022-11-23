<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('districts')->count();
        if ($count == 0) {
            $path = base_path('db/districts.sql');
            DB::unprepared(file_get_contents($path));
        }
    }
}
