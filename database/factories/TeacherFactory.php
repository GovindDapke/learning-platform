<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Teacher::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Create a new user and get its ID
            'photo' => 'img/team-2.jpg',    // Default photo path
            'subject' => $this->faker->word, // Random subject
        ];
    }
}
