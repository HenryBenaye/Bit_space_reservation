<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'name' =>$this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'reservations' =>$this->faker->numberBetween(1,5)
        ];
    }
}