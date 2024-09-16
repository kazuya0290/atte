<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $startTime = $this->faker->dateTimeThisYear();
        $endTime = $this->faker->dateTimeBetween($startTime, 'now'); 
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'rest_time' => $this->faker->numberBetween(0, 3600), 
            'total' => $this->faker->numberBetween(0, 86400), 
        ];
    }
}
