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
                <td class="attendance__data"><?php
                                                $startBreak = strtotime($attendance->break_start_time);
                                                $endBreak = strtotime($attendance->break_end_time);
                                                $totalBreakTimeInSeconds = $endBreak - $startBreak;
                                                $hours = floor($totalBreakTimeInSeconds / 3600);
                                                $minutes = floor(($totalBreakTimeInSeconds % 3600) / 60);
                                                $seconds = $totalBreakTimeInSeconds % 60;
                                                // ゼロパディングして2桁表示にする
                                                $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                                                $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                                                $formattedSeconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
                                                ?>
                    {{ $formattedHours }}:{{ $formattedMinutes }}:{{ $formattedSeconds }}
                </td>
                <td class="attendance__data"><?php
                                                $startTime = strtotime($attendance->start_time);
                                                $endTime = strtotime($attendance->end_time);
                                                $totalWorkTimeInSeconds = $endTime - $startTime;

                                                // トータル休憩時間を取得
                                                $breakStartTime = strtotime($attendance->break_start_time);
                                                $breakEndTime = strtotime($attendance->break_end_time);
                                                $totalBreakTimeInSeconds = $breakEndTime - $breakStartTime;

                                                // 勤務時間から休憩時間を引く
                                                $totalWorkTimeInSeconds -= $totalBreakTimeInSeconds;

                                                $hours = floor($totalWorkTimeInSeconds / 3600);
                                                $minutes = floor(($totalWorkTimeInSeconds % 3600) / 60);
                                                $seconds = $totalWorkTimeInSeconds % 60;
                                                // ゼロパディングして2桁表示にする
                                                $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                                                $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                                                $formattedSeconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
                                                ?>
                    {{ $formattedHours }}:{{ $formattedMinutes }}:{{ $formattedSeconds }}
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5">勤怠データがありません</td>
            </tr>
            @endif


        </table>
    </div>
</div>
@endsection