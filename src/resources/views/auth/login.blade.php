@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="login-form">
    <h2 class="login-form__heading content__heading">ログイン</h2>
    <div class="login-form__inner">
        <form class="login-form__form" action="/login" method="post">
            @csrf
            <div class="login-form__group">
                <input class="login-form__input" type="mail" name="email" id="email" placeholder="メールアドレス" value="{{ old('email') }}">
                <p class="register-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="login-form__group">
                <input class="login-form__input" type="password" name="password" id="password" placeholder="パスワード">
                <p class="register-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <input class="login-form__btn btn" type="submit" value="ログイン">
        </form>
        <div class="demo-account-info" style="margin-top: 20px; color: #d00; text-align: center;">
        <strong>【デモログイン用アカウント】</strong><br>
            デモユーザー1：demo1@example.com / password<br>
            デモユーザー2：demo2@example.com / password<br>
            デモユーザー3：demo3@example.com / password
</div>

        <div class="registration-options">
            <p class="registration_guidance">アカウントをお持ちでない方はこちらから</p>
            <a class="register-button" href="/register">会員登録</a>
        </div>
    </div>
</div>
@endsection('content')