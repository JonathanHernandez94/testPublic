<?php

namespace Database\Factories;

use App\Enums\Models\Project\ProjectStatus;
use App\Enums\Models\Project\ProjectVisibility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+6 months');

        return [
            'title' => fake()->unique()->word(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => fake()->numberBetween(ProjectStatus::COMPLETED->value, ProjectStatus::PLANNING->value),
            'description' => fake()->text(),
            'visibility' => fake()->numberBetween(ProjectVisibility::PUBLIC->value, ProjectVisibility::PRIVATE->value),
        ];
    }
}
