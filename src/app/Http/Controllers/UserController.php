<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class UserController extends Controller
{
    /*------------------------*/
    /* ユーザー一覧ページ表示
    /*------------------------*/
    public function index()
    {
        // ユーザー情報取得
        $users = User::Paginate(5);

        return view('user', compact('users'));
    }

    /*------------------------*/
    /* ユーザー詳細ページ表示
    /*------------------------*/
    public function show(Request $request)
    {
        // 飛んできたページ数
        $page = $request->page;

        // 表示させたいユーザーID
        $id = $request->id;

        // 表示させたいユーザー情報を取得
        $user = User::find($id);

        // 選択された年月を設定（初期表示は現在の年月）
        if ($request->has('month')) {
            $month = CarbonImmutable::parse($request->month);
        } else {
            $month = CarbonImmutable::now();
        }

        // 月初めと月末の日付を取得
        $from = $month->firstOfMonth()->format('Y-m-d');
        $to = $month->endOfMonth()->format('Y-m-d');

        // データ取得処理
        $attendances = Attendance::with('rest', 'user')
        ->where('user_id', $id)
        ->whereBetween('date', [$from, $to])
        ->orderBy('date', 'ASC')
        ->get();

        // 休憩時間取得処理
        $attendances = Attendance::getRestTimes($attendances);

        return view('detail', compact('page', 'id', 'user', 'month', 'attendances'));
    }

}
