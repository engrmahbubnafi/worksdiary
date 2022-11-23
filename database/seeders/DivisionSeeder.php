<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('divisions')->count();
        if ($count == 0) {
            $path = base_path('db/divisions.sql');
            DB::unprepared(file_get_contents($path));
        }
    }
}
