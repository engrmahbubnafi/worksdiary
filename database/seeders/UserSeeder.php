<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('users')->count();
        if ($count < 2) {

            User::factory()->create([
                'name'          => 'Administrator',
                'email'         => 'administrator@example.com',
                'role_id'       => Role::factory()->create([
                    'name'         => 'Administrator',
                    'is_editable'  => 0,
                    'is_deletable' => 0,
                    'description'  => 'This is for super-admin',
                ]),
                'department_id' => Department::factory()->create(),
                'company_id'    => 1,
            ]);

            User::factory()->create([
                'name'          => 'Admin',
                'email'         => 'admin@example.com',
                'role_id'       => Role::factory()->create(),
                'department_id' => Department::factory()->create(),
                'company_id'    => 2,
            ]);
        }
    }
}