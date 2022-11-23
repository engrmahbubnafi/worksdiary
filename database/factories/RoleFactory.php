<?php

namespace Database\Factories;

use App\Enum\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'is_editable' => 1,
            'is_deletable' => 1,
            'description' => $this->faker->sentence,
            'status' => Status::Active,
        ];
    }
}
