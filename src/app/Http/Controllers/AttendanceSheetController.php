<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AttendanceSheetController extends Controller
{
    public function index(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));


        // 指定されたユーザーに関連するすべての日付を取得する
        $dates = Attendance::select('stamp_date')
        ->where('user_id', $user->id)
        ->distinct()
        ->pluck('stamp_date');

        // 日付ごとに勤怠データを取得する
        $attendanceData = collect([]);

        foreach ($dates as $date) {
            $attendanceDataForDate = Attendance::select(
            'users.name as user_name', // ユーザー名を取得するためにユーザーテーブルを結合
            'stamp_date',
            DB::raw('MAX(CASE WHEN action = "startWork" THEN start_time END) AS start_time'),
            DB::raw('MAX(CASE WHEN action = "endWork" THEN end_time END) AS end_time'),
            DB::raw('GROUP_CONCAT(CASE WHEN action = "startBreak" THEN break_start_time END) AS break_start_times'),
            DB::raw('GROUP_CONCAT(CASE WHEN action = "endBreak" THEN break_end_time END) AS break_end_times'),

            DB::raw('TIMESTAMPDIFF(MINUTE, MAX(CASE WHEN action = "startWork" THEN start_time END), MAX(CASE WHEN action = "endWork" THEN end_time END)) AS total_work_time')
        )
            ->join('users', 'users.id', '=', 'attendances.user_id')
            // ユーザーテーブルを結合
            ->where('stamp_date',$date)
            ->where('user_id', $user->id) // ユーザーIDでフィルタリング
            ->groupBy('users.name', 'stamp_date') // ユーザー名と日付でグループ化
            ->whereYear('stamp_date', '=', date('Y', strtotime($selectedMonth)))
            ->whereMonth('stamp_date', '=', date('m', strtotime($selectedMonth)))
            ->get();


            if ($attendanceDataForDate->isNotEmpty()) {
                $attendanceData = $attendanceData->merge($attendanceDataForDate);
            }

        }
        // 日付を降順にソートする
        $attendanceData = $attendanceData->sortBy('stamp_date');

        return view('attendance-sheet.index', compact('user','attendanceData', 'selectedMonth'));
    }
    public function monthly(Request $request)
    {
        // リクエストから月を取得する（もしくはデフォルトの月を使用する）
        $selectedMonth = $request->input('month', date('Y-m'));

        // 指定されたユーザーに関連するすべての日付を取得する
        $dates = Attendance::select('stamp_date')
            ->distinct()
            ->pluck('stamp_date');

        // 日付ごとに勤怠データを取得する
        $attendanceData = collect([]);

        foreach ($dates as $date) {
            $attendanceDataForDate = Attendance::select(
                'users.name as user_name', // ユーザー名を取得するためにユーザーテーブルを結合
                'stamp_date',
                DB::raw('MAX(CASE WHEN action = "startWork" THEN start_time END) AS start_time'),
                DB::raw('MAX(CASE WHEN action = "endWork" THEN end_time END) AS end_time'),
                DB::raw('GROUP_CONCAT(CASE WHEN action = "startBreak" THEN break_start_time END) AS break_start_times'),
                DB::raw('GROUP_CONCAT(CASE WHEN action = "endBreak" THEN break_end_time END) AS break_end_times'),

                DB::raw('TIMESTAMPDIFF(MINUTE, MAX(CASE WHEN action = "startWork" THEN start_time END), MAX(CASE WHEN action = "endWork" THEN end_time END)) AS total_work_time')
            )
            ->join('users', 'users.id', '=', 'attendances.user_id')
        // ユーザーテーブルを結合
            ->where('stamp_date', $date)
            ->groupBy('users.name', 'stamp_date') // ユーザー名と日付でグループ化
            ->whereYear('stamp_date', '=', date('Y', strtotime($selectedMonth)))
            ->whereMonth('stamp_date', '=', date('m', strtotime($selectedMonth)))
            ->get();


            if ($attendanceDataForDate->isNotEmpty()) {
                $attendanceData = $attendanceData->merge($attendanceDataForDate);
            }

        // 日付を降順にソートする
            $attendanceData = $attendanceData->sortBy('stamp_date');

        // ビューを返す
        return view('attendance-sheet.index', compact('user','selectedMonth', 'attendanceData'));
    }

    }
}