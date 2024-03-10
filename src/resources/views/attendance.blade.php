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
        <table class="attendance__table">
            <tr class="attendance__row">
                <th class="attendance__label">名前</th>
                <th class="attendance__label">勤務開始</th>
                <th class="attendance__label">勤務終了</th>
                <th class="attendance__label">休憩時間</th>
                <th class="attendance__label">勤務時間</th>
            </tr>
            <!--
            @foreach($contacts as $contact)
            <tr class="admin__row">
                <td class="admin__data">{{$contact->first_name}}{{$contact->last_name}}</td>
                <td class="admin__data">
                    @if($contact->gender == 1)
                    男性
                    @elseif($contact->gender == 2)
                    女性
                    @else
                    その他
                    @endif
                </td>
                <td class="admin__data">{{$contact->email}}</td>
                <td class="admin__data">{{$contact->category->content}}</td>
                <td class="admin__data">
                    <a class="admin__detail-btn" href="#{{$contact->id}}">詳細</a>
                </td>
            </tr>
            -->
            {{ $contacts->links('vendor.pagination.default') }}<!-- テーブル名を確認-->
        </table>
    </div>
</div>