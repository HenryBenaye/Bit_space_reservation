<?php

namespace Database\Factories;

use App\Models\Space;
use App\Models\Student;
use App\Models\User;
use DateTime;
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
        $begin_time = $this->faker->dateTimeBetween('08:30:00', '17:00:00')->format('H:i:s');
        $datetime = new DateTime($begin_time);
        $end_time = $datetime->add(new \DateInterval('PT1H'))->format('H:i:s');
        if (strtotime($end_time) > strtotime('17:00:00'))
        {
            $end_time = strtotime('17:00:00');
            $end_time = date('H:i:s', $end_time);
        }

        return [
            'user_id' => User::factory(),
            'space_id' => $this->faker->numberBetween(1,5),
            'begin_time' => $begin_time ,
            'end_time' =>$end_time
        ];
    }
}
