<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpazilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('upazilas')->count();
        if ($count == 0) {
            $path = base_path('db/upazilas.sql');
            DB::unprepared(file_get_contents($path));
        }
    }
}
