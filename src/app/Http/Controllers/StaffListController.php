<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;

class StaffListController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $users = User::paginate(5); // ページネーションを適用

        return view('staff.index', compact('users', 'selectedMonth'));
    }
}
