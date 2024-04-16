@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('link')
<ul class="header-nav">
    @if(auth()->check())
    <li class="header-nav__item">
        <a class="header-nav__link" href="/">ホーム</a>
        <a class="header-nav__link" href="/attendance">日付別勤怠</a>
        <a class="header-nav__link" href="/staff">社員一覧</a>
    </li>
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
<div class="stamp-form">
    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->has('action'))
    <div class="alert-danger">
        <ul>
            @foreach ($errors->get('action') as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(auth()->check())
    <h2 class="stamp-form__heading content__heading">{{ auth()->user()->name }}さんお疲れ様です！</h2>
    @else
    <div class=stamp-form__login-button>
        <a class="login-button" href="/login">ここからログインしてください</a>
    </div>

    @endif
    <div class="today_date">今日は{{ $todayDate }}です</div>

    <form class="stamp-form__container" action="/record" method="post">
        @csrf
        <input type="hidden" name="stamp_date" value="{{ $todayDate }}">

        <!-- 勤務開始ボタン -->
        <button type="submit" name="action" value="startWork" @if(!auth()->check() ||$attendanceStatus=='startWork' || $attendanceStatus=='endWork' || $attendanceStatus=='startBreak' || $attendanceStatus=='endBreak' ) disabled @endif>
            勤務開始
        </button>

        <!-- 勤務終了ボタン -->
        <button type="submit" name="action" value="endWork" @if($attendanceStatus!='startWork' && $attendanceStatus!='endBreak' ||$attendanceStatus=='endWork' ||$attendanceStatus=='startBreak' ) disabled @endif>
            勤務終了
        </button>

        <!-- 休憩開始ボタン -->
        <button type="submit" name="action" value="startBreak" @if($attendanceStatus=='startBreak' || $attendanceStatus=='endWork' || $attendanceStatus!='startWork' && $attendanceStatus!='endBreak' ) disabled @endif>
            休憩開始
        </button>

        <!-- 休憩終了ボタン -->
        <button type="submit" name="action" value="endBreak" @if($attendanceStatus!='startWork' && $attendanceStatus!='startBreak' || $attendanceStatus=='endBreak' ||$attendanceStatus=='endWork' ||$attendanceStatus=='startWork' )disabled @endif>
            休憩終了
        </button>


    </form>
</div>
@endsection