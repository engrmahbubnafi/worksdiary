<?php

namespace Database\Factories;

use App\Enum\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'   => $this->faker->name,
            'code'   => $this->faker->numerify('company-####'),
            'status' => Status::Active,
        ];
    }
}
