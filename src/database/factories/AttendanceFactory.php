<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userId = $this->faker->numberBetween(1, 10);
        $stampDate = $this->faker->dateTimeBetween('-5 days', 'now')->format('Y-m-d');
        $actions = ['startWork', 'endWork', 'startBreak', 'endBreak'];

        $data = [];
        foreach ($actions as $action) {
            $data[] = [
                'id' => null,
                'user_id' => $userId,
                'stamp_date' => $stampDate,
                'action' => $action,
                'start_time' => ($action === 'startWork') ? $this->faker->dateTimeBetween('08:00:00', '11:00:00')->format('H:i:s') : null,
                'end_time' => ($action === 'endWork') ? $this->faker->dateTimeBetween('15:00:00', '20:00:00')->format('H:i:s') : null,
                'break_start_time' => ($action === 'startBreak') ? $this->faker->dateTimeBetween('12:00:00', '13:00:00')->format('H:i:s') : null,
                'break_end_time' => ($action === 'endBreak') ? $this->faker->dateTimeBetween('12:30:00', '13:30:00')->format('H:i:s') : null,
            ];
        }

        // ループが終了した後に配列の中身を返す
        return $data;
    }
}
