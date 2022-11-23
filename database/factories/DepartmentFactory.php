<?php

namespace Database\Factories;

use App\Enum\Status;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => Company::factory()->create(),
            'name'       => $this->faker->name,
            'code'       => $this->faker->numerify('dept-####'),
            'status'     => Status::Active,
        ];
    }
}
