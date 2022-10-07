<?php

namespace Database\Factories;

use App\Models\Space;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date_begin = $this->faker->dateTime();
        return [
            'student_id' => Student::factory()->create(),
            'space_id' => Space::factory(),
            'begin_time' => $this->faker->dateTime(),
            'end_time' => $this->faker->dateTimeBetween($date_begin,'+1 hours')
        ];
    }
}
