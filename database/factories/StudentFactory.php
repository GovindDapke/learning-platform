<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'teacher_id' => \App\Models\Teacher::inRandomOrder()->first()->id, // Randomly assign a teacher
            'photo' => 'img/team-3.jpg', 
            'admission_date' => $this->faker->date(),
            'yearly_fees' => $this->faker->numberBetween(20000, 50000),
        ];
    }
}
