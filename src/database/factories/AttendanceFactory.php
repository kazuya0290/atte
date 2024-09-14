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
        // `start_time` と `end_time` を生成する
        $startTime = $this->faker->dateTimeThisYear();
        $endTime = $this->faker->dateTimeBetween($startTime, 'now'); // `start_time` より後の時間を生成

        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'rest_time' => $this->faker->numberBetween(0, 3600), // 0秒から1時間（3600秒）までの整数
            'total' => $this->faker->numberBetween(0, 86400), // 0秒から1日の秒数（86400秒）までの整数
        ];
    }
}
