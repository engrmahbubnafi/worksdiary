<?php

namespace Database\Seeders;

use App\Enum\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('unit_types')->count();
        if (!$count) {
            DB::table('unit_types')->insert(
                [
                    [
                        'name' => 'Shop',
                        'is_slot_enabled' => false,
                        'status' => Status::Active,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Farm',
                        'is_slot_enabled' => false,
                        'status' => Status::Active,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Pond',
                        'is_slot_enabled' => true,
                        'status' => Status::Active,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]
            );
        }
    }
}
