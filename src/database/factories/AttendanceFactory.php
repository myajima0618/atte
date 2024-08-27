<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Rest;
use Carbon\Carbon;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $dummy_date = $this->faker->dateTimeBetween('-3months', 'now');
        $dummy_time = $this->faker->dateTimeBetween('06:00:00', '12:00:00');

        return [
            'user_id' => $this->faker->numberBetween(1, 50),
            'date' => $dummy_date->format('Y-m-d'),
            'check_in_time' => $dummy_time->format('H:i:s'),
            'check_out_time' => $dummy_time->modify('+9hours')->format('H:i:s'),
            'status' => '2',
        ];
    }
}
