<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) { // ユーザー1〜20人分
            for ($d = 0; $d < 10; $d++) { // 各ユーザーに10日分のデータ
                $date = Carbon::now()->subDays(rand(1, 60))->format('Y-m-d');

                // 時刻を1日分まとめて作成
                $startWork = $faker->dateTimeBetween("$date 08:00:00", "$date 09:30:00");
                $endWork = $faker->dateTimeBetween("$date 17:00:00", "$date 19:00:00");
                $breakStart = $faker->dateTimeBetween("$date 12:00:00", "$date 13:00:00");
                $breakEnd = $faker->dateTimeBetween($breakStart, "$date 14:00:00");

                // 勤務開始
                Attendance::create([
                    'user_id' => $i,
                    'stamp_date' => $date,
                    'action' => 'startWork',
                    'start_time' => $startWork->format('H:i:s'),
                ]);

                // 勤務終了
                Attendance::create([
                    'user_id' => $i,
                    'stamp_date' => $date,
                    'action' => 'endWork',
                    'end_time' => $endWork->format('H:i:s'),
                ]);

                // 休憩開始
                Attendance::create([
                    'user_id' => $i,
                    'stamp_date' => $date,
                    'action' => 'startBreak',
                    'break_start_time' => $breakStart->format('H:i:s'),
                ]);

                // 休憩終了
                Attendance::create([
                    'user_id' => $i,
                    'stamp_date' => $date,
                    'action' => 'endBreak',
                    'break_end_time' => $breakEnd->format('H:i:s'),
                ]);
            }
        }
    }
}
