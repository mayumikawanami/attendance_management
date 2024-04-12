@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-sheet/index.css')}}">
@endsection

@section('link')
<ul class="header-nav">
    <li class="header-nav__item">
        <a class="header-nav__link" href="/">ホーム</a>
        <a class="header-nav__link" href="/attendance">日付別勤怠</a>
        <a class="header-nav__link" href="/staff">社員一覧</a>
    </li>
    @if(auth()->check())
    <li class="header-nav__item">
        <form action="/logout" method="post">
            @csrf
            <input class="header-nav__link" type="submit" value="ログアウト">
        </form>
    </li>
    @endif
</ul>
@endsection

@section('content')
<div class="attendance-sheet-form">
    @if(isset($user))
    <h2 class="attendance-sheet-form__heading content__heading">{{ $user->name }}さんの勤怠表　〜{{ date('Y年n月', strtotime($selectedMonth))}}〜</h2>
    @else
    <h2 class="attendance-sheet-form__heading content__heading">社員を選択して下さい</h2>
    @endif
    <div class="attendance-sheet-form__select-month">
        <form action="{{ route('attendance.sheet', ['id' => $user->id]) }}" method="GET">
            <label for="month">月を選択：</label>
            <input class="select-month_input" type="month" id="month" name="month">
            <button class="select-month_btn" type="submit">表示</button>
        </form>
    </div>
    <div class="attendance-sheet-form__container">
        <table class="attendance-sheet__table">
            <tr class="attendance-sheet__row">
                <th class="attendance-sheet__label">日付</th>
                <th class="attendance-sheet__label">勤務開始</th>
                <th class="attendance-sheet__label">勤務終了</th>
                <th class="attendance-sheet__label">休憩時間</th>
                <th class="attendance-sheet__label">勤務時間</th>
            </tr>
            @if($attendanceData ->isNotEmpty())
            @foreach($attendanceData as $attendance)
            <tr class="attendance__row">
                <td class="attendance-sheet__data">{{ $attendance->stamp_date->format('Y-m-d')}}</td>
                <td class="attendance-sheet__data">{{ $attendance->start_time }}</td>
                <td class="attendance-sheet__data">{{ $attendance->end_time }}</td>
                <td class="attendance-sheet__data">
                    <?php
                    // 休憩開始時刻と終了時刻を取得する
                    $breakStartTimes = explode(',', $attendance->break_start_times);
                    $breakEndTimes = explode(',', $attendance->break_end_times);

                    // 休憩開始が打刻されているかをチェックする
                    $isBreakStarted = !empty($breakStartTimes) && $breakStartTimes[0] !== '';

                    // 休憩終了が打刻されているかをチェックする
                    $isBreakEnded = !empty($breakEndTimes) && $breakEndTimes[0] !== '';

                    // 休憩開始が打刻されている場合は、休憩時間を計算する
                    if ($isBreakStarted && $isBreakEnded && count($breakStartTimes) === count($breakEndTimes)) {
                        // 各休憩時間の差分を合計する
                        $totalBreakTimeInSeconds = 0;
                        for ($i = 0; $i < count($breakStartTimes); $i++) {
                            $startBreak = strtotime($breakStartTimes[$i]);
                            $endBreak = strtotime($breakEndTimes[$i]);
                            $totalBreakTimeInSeconds += $endBreak - $startBreak;
                        }

                        // 合計休憩時間を時分秒に変換する
                        $hours = floor($totalBreakTimeInSeconds / 3600);
                        $minutes = floor(($totalBreakTimeInSeconds % 3600) / 60);
                        $seconds = $totalBreakTimeInSeconds % 60;

                        // ゼロパディングして2桁表示にする
                        $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                        $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                        $formattedSeconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);

                        echo $formattedHours . ':' . $formattedMinutes . ':' . $formattedSeconds;
                    } else {
                        // 休憩開始が打刻されていない場合は何も表示しない
                        echo '';
                    }
                    ?>
                </td>



                <td class="attendance-sheet__data">
                    <?php
                    $startTime = strtotime($attendance->start_time);
                    $endTime = strtotime($attendance->end_time);

                    // 勤務時間が打刻されていない場合は何も表示しない
                    if ($startTime !== false && $endTime !== false) {
                        $totalWorkTimeInSeconds = $endTime - $startTime;

                        // 各休憩時間の開始時刻と終了時刻を取得し、処理する
                        $breakStartTimes = explode(',', $attendance->break_start_times);
                        $breakEndTimes = explode(',', $attendance->break_end_times);

                        $totalBreakTimeInSeconds = 0;
                        // 各休憩時間の差分を合計する
                        for ($i = 0; $i < count($breakStartTimes); $i++) {
                            $startBreak = strtotime($breakStartTimes[$i]);
                            $endBreak = strtotime($breakEndTimes[$i]);
                            $totalBreakTimeInSeconds += $endBreak - $startBreak;
                        }
                        // 勤務時間から休憩時間を引く
                        $totalWorkTimeInSeconds -= $totalBreakTimeInSeconds;

                        $hours = floor($totalWorkTimeInSeconds / 3600);
                        $minutes = floor(($totalWorkTimeInSeconds % 3600) / 60);
                        $seconds = $totalWorkTimeInSeconds % 60;
                        // ゼロパディングして2桁表示にする
                        $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                        $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                        $formattedSeconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
                        echo $formattedHours . ':' . $formattedMinutes . ':' . $formattedSeconds;
                    } else {
                        // 勤務時間が打刻されていない場合は何も表示しない
                        echo '';
                    }
                    ?>
                </td>
            </tr>
            @endforeach
            @else
            <tr class="no-data-row">
                <td colspan="5">勤怠データがありません</td>
            </tr>
            @endif
        </table>
    </div>
</div>
@endsection