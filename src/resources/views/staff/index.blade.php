@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/staff/index.css')}}">
@endsection

@section('link')
<ul class="header-nav">
    <li class="header-nav__item">
        <a class="header-nav__link" href="/">ホーム</a>
        <a class="header-nav__link" href="/attendance">日付一覧</a>
        <a class="header-nav__link" href="/staff">社員一覧</a>
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
<div class="staff-list-form">
    <h2 class="staff-list-form__heading content__heading">社員一覧</h2>

    <div class="staff-list-form__container">
        <table class="staff-list__table">
            <tr class="staff-list__row">
                <th class="staff-list__label">ID</th>
                <th class="staff-list__label">名前</th>
            </tr>
            @if($users->isNotEmpty())
            @foreach($users as $user)
            <tr class="staff-list__row">
                <td class="staff-list__data">{{ $user->id }}</td>
                <td class="staff-list__data"> <!-- 各社員の名前にリンクを追加 -->
                    <a href="{{ route('attendance.sheet', ['id' => $user->id, 'month' => $selectedMonth]) }}">{{ $user->name }}
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5">社員データがありません</td>
            </tr>
            @endif
        </table>
        {{ $users->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection