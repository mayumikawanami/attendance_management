<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;
use Carbon\Carbon; // Carbonライブラリを使用するために追加
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AttendanceController extends Controller
{
    public function index()
    {
        $todayDate = now()->format('Y-m-d');
        $attendanceStatus = null;

        if (auth()->check()) {
            // ユーザーの最後の打刻アクションを取得
            $lastAction = Attendance::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->first();

            // もし今日の日付が前回のアクションと違う場合、状態をリセット
            if ($lastAction && $lastAction->stamp_date->format('Y-m-d') !== $todayDate) {
                $attendanceStatus = null;
            } else {
                $attendanceStatus = $lastAction ? $lastAction->action : null;
            }
        }

        return view('index', compact('todayDate', 'attendanceStatus'));
    }

    public function attendance(Request $request)
    {
        // リクエストから日付を取得する（もしくはデフォルトの日付を使用する）
        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        // 前の日付を計算
        $previousDate = date('Y-m-d', strtotime($selectedDate . ' -1 day'));

        // 次の日付を計算
        $nextDate = date('Y-m-d', strtotime($selectedDate . ' +1 day'));


            $attendanceData = Attendance::select(
                'users.name as user_name', // ユーザー名を取得するためにユーザーテーブルを結合
                'stamp_date',
                DB::raw('MAX(CASE WHEN action = "startWork" THEN start_time END) AS start_time'),
                DB::raw('MAX(CASE WHEN action = "endWork" THEN end_time END) AS end_time'),
                DB::raw('GROUP_CONCAT(CASE WHEN action = "startBreak" THEN break_start_time END) AS break_start_times'),
                DB::raw('GROUP_CONCAT(CASE WHEN action = "endBreak" THEN break_end_time END) AS break_end_times'),

                DB::raw('TIMESTAMPDIFF(MINUTE, MAX(CASE WHEN action = "startWork" THEN start_time END), MAX(CASE WHEN action = "endWork" THEN end_time END)) AS total_work_time')
            )
            ->join('users', 'users.id','=','attendances.user_id')
             // ユーザーテーブルを結合
            ->where('stamp_date', $selectedDate)
            ->groupBy('users.name', 'stamp_date') // ユーザー名と日付でグループ化
            ->paginate(5); // ページネーションで1ページあたり5件表示

        $attendanceData->appends(['date' => $selectedDate]); // 日付情報をページネーションのリンクに追加

        return view('attendance', compact('selectedDate', 'previousDate', 'nextDate', 'attendanceData'));
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

        // 直前の打刻アクションの時刻を取得
        $lastAction = Attendance::where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')
        ->first();

        // 直前の打刻アクションがある場合、一定時間内の連続クリックをチェック
        if ($lastAction) {
            $timeThreshold = $lastAction->created_at->addSeconds(7); // 一定時間内のクリックを制限する時間
            if (now()->lt($timeThreshold)) {
                // アクションごとに異なる警告メッセージを設定
                switch ($formData['action']) {
                    case 'startWork':
                        $warningMessage = "連続クリックのため 最初の打刻で勤務開始しました";
                        break;
                    case 'endWork':
                        $warningMessage = "連続クリックのため 最初の打刻で勤務終了しました";
                        break;
                    case 'startBreak':
                        $warningMessage = "連続クリックのため 最初の打刻で休憩開始しました";
                        break;
                    case 'endBreak':
                        $warningMessage = "連続クリックのため 最初の打刻で休憩終了しました";
                        break;
                        // 他のボタンに対する処理も追加できます
                    default:
                        $warningMessage = '一定時間内の連続クリックは無効です。';
                }

                return redirect()->back()->with('warning', $warningMessage);
            }
        }

        // 休憩開始が打刻されている場合は、休憩時間を計算する
        if ($formData['action'] == 'startBreak') {
            $formData['break_start_time'] = now();
        } elseif ($formData['action'] == 'endBreak') {
            $formData['break_end_time'] = now();
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
