<?php

namespace Database\Seeders;

use App\Enum\Status;
use App\Models\FieldType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Run seeder only if there is no data in field_types table.
         */
        $count = DB::table('field_types')->count();

        if (!$count) {
            FieldType::factory()->create([
                'input_type' => 'label',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'dropdown',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'button',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'checkbox',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'color',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'date',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'datetime-local',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'email',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'file',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'hidden',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'image',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'month',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'number',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'password',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'radio',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'range',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'reset',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'search',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'submit',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'tel',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'text',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'time',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'url',
                'status' => Status::Active,
            ]);

            FieldType::factory()->create([
                'input_type' => 'week',
                'status' => Status::Active,
            ]);
        }
    }
}
