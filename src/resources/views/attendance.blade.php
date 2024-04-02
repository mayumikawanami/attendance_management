@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css')}}">
@endsection

@section('link')
<ul class="header-nav">
    <li class="header-nav__item">
        <a class="header-nav__link" href="/">ホーム</a>
        <a class="header-nav__link" href="/attendance">日付一覧</a>
    </li>
    <li class="header-nav__item">
        <form action="/logout" method="post">
            @csrf
            <input class="header-nav__link" type="submit" value="ログアウト">
        </form>
    </li>
</ul>
@endsection

@section('content')
<div class="attendance-form">
    <h2 class="attendance-form__heading content__heading"></h2>
    <div class="attendance-form__container">
        <div class="date-navigation">
            <a href="{{ route('attendance', ['date' => $previousDate]) }}" class="date-navigation__button">&lt;</a>
            <span class="current-date">{{ $selectedDate }}</span>
            <a href="{{ route('attendance', ['date' => $nextDate]) }}" class="date-navigation__button">&gt;</a>
        </div>
        <table class="attendance__table">
            <tr class="attendance__row">
                <th class="attendance__label">名前</th>
                <th class="attendance__label">勤務開始</th>
                <th class="attendance__label">勤務終了</th>
                <th class="attendance__label">休憩時間</th>
                <th class="attendance__label">勤務時間</th>
            </tr>
            @if($attendanceData->isNotEmpty())
            @foreach($attendanceData as $attendance)
            <tr class="attendance__row">
                <td class="attendance__data">{{ $attendance->user_name }}</td>
                <td class="attendance__data">{{ $attendance->start_time }}</td>
                <td class="attendance__data">{{ $attendance->end_time }}</td>
                <td class="attendance__data">
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



                <td class="attendance__data">
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
            <tr>
                <td colspan="5">勤怠データがありません</td>
            </tr>
            @endif
        </table>
        {{ $attendanceData->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection