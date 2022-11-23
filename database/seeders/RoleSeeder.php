<?php

namespace Database\Seeders;

use App\Enum\Status;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $count = DB::table('roles')->count();
        if ($count < 4) {

            Role::factory()->create([
                'name' => 'Administrator',
                'is_editable' => 0,
                'is_deletable' => 0,
                'description' => 'This is for super-admin',
            ]);

            Role::factory(3)->create();

            // DB::table('roles')->insert(
            //     [
            //         [
            //             'name' => 'Administrator',
            //             'is_editable' => 0,
            //             'is_deletable' => 0,
            //             'description' => 'This is for super-admin',
            //             'status' => Status::Active,
            //             'created_at' => now(),
            //             'updated_at' => now(),
            //         ],
            //         [
            //             'name' => 'Admin',
            //             'is_editable' => 1,
            //             'is_deletable' => 1,
            //             'description' => 'This is for admin',
            //             'status' => Status::Active,
            //             'created_at' => now(),
            //             'updated_at' => now(),
            //         ],
            //     ]
            // );
        }
    }
}
