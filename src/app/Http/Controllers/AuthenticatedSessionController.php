<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        // ユーザーログイン処理
        if (Auth::attempt($request->only('email', 'password'))) {
            // ログイン成功時の処理
            return redirect(RouteServiceProvider::HOME); // ログイン後に遷移する先を指定
        } else {
            // ログイン失敗時の処理
            return back()->withErrors(['email' => 'ログインに失敗しました。']); // ログインページにエラーを表示
        }
    }

    public function destroy()
    {
        // ユーザーログアウト処理
        Auth::logout();

        // ログアウト後に遷移する先を指定
        return redirect('/login');
    }
}
