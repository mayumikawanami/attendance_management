<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Attendance;
use App\Models\User;


class AttendanceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * テストケース：出勤を記録する
     *
     * @return void
     */
    public function testRecordAttendance()
    {
        // 従業員を作成し、そのIDを取得する
        $employee = User::factory()->create();
        $userId = $employee->id;

        // 出勤を記録する
        $attendance = new Attendance();
        $attendance->user_id = $userId;
        $attendance->action = 'arrival'; // 出勤アクションを追加
        $attendance->start_time = '09:00:00';
        $attendance->save();

        // 出勤が正しく記録されたかを検証
        $this->assertDatabaseHas('attendances', [
            'user_id' => $userId,
            'action' => 'arrival',
            'start_time' => '09:00:00'
        ]);
    }

    /**
     * テストケース：退勤を記録する
     *
     * @return void
     */
    public function testRecordLeave()
    {
        // 従業員を作成し、そのIDを取得する
        $employee = User::factory()->create();
        $userId = $employee->id;

        // 退勤を記録する
        $attendance = new Attendance();
        $attendance->user_id = $userId;
        $attendance->action = 'leave'; // 退勤アクションを追加
        $attendance->end_time = '18:00:00';
        $attendance->save();

        // 退勤が正しく記録されたかを検証
        $this->assertDatabaseHas('attendances', [
            'user_id' => $userId,
            'action' => 'leave',
            'end_time' => '18:00:00'
        ]);
    }
    /**
     * テストケース：休憩を記録する
     *
     * @return void
     */
    public function testRecordBreak()
    {
        // 従業員を作成し、そのIDを取得する
        $employee = User::factory()->create();
        $userId = $employee->id;

        // 休憩を記録する
        $attendance = new Attendance();
        $attendance->user_id = $userId;
        $attendance->action = 'break'; // 休憩アクションを追加
        $attendance->break_start_time = '12:00:00';
        $attendance->break_end_time = '12:30:00';
        $attendance->save();

        // 休憩が正しく記録されたかを検証
        $this->assertDatabaseHas('attendances', [
            'user_id' => $userId,
            'action' => 'break',
            'break_start_time' => '12:00:00',
            'break_end_time' => '12:30:00'
        ]);
    }

    /**
     * テストケース：勤怠情報を確認する
     *
     * @return void
     */
    public function testViewAttendanceSheet()
    {
        // 従業員を作成し、そのIDを取得する
        $employee = User::factory()->create();
        $userId = $employee->id;

        // 勤怠情報を表示するためのAPIエンドポイントにリクエストを送信
        $response = $this->get("/attendance-sheet/{$userId}");


        // リクエストのレスポンスが正しい形式であることを検証
        $response->assertStatus(200);
        /* $response->assertJsonStructure([
            'user_id',
            'attendance_data' => [
                '*' => [
                    'stamp_date',
                    'start_time',
                    'end_time',
                    'break_start_times',
                    'break_end_times',
                    'total_work_time',
                    'total_break_time'
                ]
            ]
        ]); */

    }
}
