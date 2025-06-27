<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition()
    {
        $userId = $this->faker->numberBetween(1, 10);
        $stampDate = $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d');

        $action = $this->faker->randomElement(['startWork', 'endWork', 'startBreak', 'endBreak']);

        // 各アクションに応じて該当する時間のみ設定
        $startTime = $endTime = $breakStartTime = $breakEndTime = null;

        switch ($action) {
            case 'startWork':
                $startTime = $this->faker->dateTimeBetween("$stampDate 08:00:00", "$stampDate 10:00:00")->format('H:i:s');
                break;
            case 'endWork':
                $endTime = $this->faker->dateTimeBetween("$stampDate 17:00:00", "$stampDate 20:00:00")->format('H:i:s');
                break;
            case 'startBreak':
                $breakStartTime = $this->faker->dateTimeBetween("$stampDate 11:30:00", "$stampDate 13:00:00")->format('H:i:s');
                break;
            case 'endBreak':
                $breakEndTime = $this->faker->dateTimeBetween("$stampDate 13:00:00", "$stampDate 14:00:00")->format('H:i:s');
                break;
        }

        return [
            'user_id' => $userId,
            'stamp_date' => $stampDate,
            'action' => $action,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'break_start_time' => $breakStartTime,
            'break_end_time' => $breakEndTime,
        ];
    }
}
