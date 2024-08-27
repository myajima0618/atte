<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dummy_time = $this->faker->DateTimeBetween('12:30:00', '14:00:00');

        return [
            'attendance_id' => Attendance::factory(),
            'rest_start_time' => $dummy_time->format('H:i:s'),
            'rest_end_time' => $dummy_time->modify('+1hour')->format('H:i:s'),
        ];
    }
}
