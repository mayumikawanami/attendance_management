<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $todayDate = now()->format('Y-m-d');

        // 当日の打刻回数を取得
        $dailyWorkCount = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('created_at', $todayDate)
            ->count();

        // ユーザーの最後の打刻アクションを取得
        $lastAction = Attendance::where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')
        ->first();

        $attendanceStatus = $lastAction ? $lastAction->action : null;
        $breakButtonsDisabled = ($attendanceStatus == 'startBreak' || $attendanceStatus == 'endBreak');
        return view('index', compact('todayDate','attendanceStatus', 'breakButtonsDisabled'));
    }

    public function record(Request $request)
    {
        $this->validate($request, [
            'action' => [
                'required',
                'in:startWork,endWork,startBreak,endBreak',
            ],
        ]);

        return $this->processAttendance($request, [
            'action' => $request->action,
            'stamp_date' => now()->format('Y-m-d'),
        ]);
    }

    public function store(AttendanceRequest $request)
    {
        return $this->processAttendance($request, [
            'action' => $request->action,
            'stamp_date' => now()->format('Y-m-d'),
        ]);

    }

    private function processAttendance(Request $request, array $formData)
    {
        // フォームデータを取得
        // ...
        // 日付が送信されていない場合は現在の日付を使用
        $stampDate = $formData['stamp_date'] ?? now()->format('Y-m-d');

        // 日を跨いでいるかどうかを判定
        $currentDate = now()->format('Y-m-d');
        $selectedDate = $stampDate ?? $currentDate;

        if (strtotime($selectedDate) < strtotime($currentDate)) {
            // 日を跨いでいる場合は翌日の日付を設定
            $selectedDate = now()->addDay()->format('Y-m-d');
        }

        // レスポンスメッセージを設定
        $message = '';

        // ボタンのアクションによってメッセージを変更
        switch ($formData['action']) {
            case 'startWork':
                $message = '勤務開始しました';
                break;
            case 'endWork':
                $message = '勤務終了しました';
                break;
            case 'startBreak':
                $message = '休憩を開始しました';
                break;
            case 'endBreak':
                $message = '休憩終了しました';
                break;
                // 他のボタンに対する処理も追加できます
        }

        // データベースに保存
        $attendance = new Attendance([
            'user_id' => auth()->user()->id,
            'action' => $formData['action'],
            'stamp_date' => $selectedDate,
            'start_time' => $formData['action'] == 'startWork' ? now() : null,
            'end_time' => $formData['action'] == 'endWork' ? now() : null,
            'break_start_time' => $formData['action'] == 'startBreak' ? now() : null,
            'break_end_time' => $formData['action'] == 'endBreak' ? now() : null,
        ]);

        $attendance->save();

        return redirect()->back()->with('success', $message);
    }
}
