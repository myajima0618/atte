<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestController extends Controller
{
    // 休憩開始ボタン押下時処理
    public function store()
    {
        // ログイン中のユーザー情報取得
        $user = Auth::user();
        // 本日の日付取得
        $today = Carbon::now()->format('Y-m-d');
        // 本日の勤務情報を取得（attendance）
        $data = Attendance::GetAttendance($user['id'], $today, false)->first();

        // 本日の勤務データが存在しない場合
        if(is_null($data)){
            // 前日の日付取得
            $yesterday = Carbon::now()->subDay()->format('Y-m-d');
            // 前日の勤務情報を取得
            $result = Attendance::GetAttendance($user['id'], $yesterday, true)->first();
            // 前日の勤務データがある場合
            if(!is_null($result)){
                // 前日の勤務終了処理を行う
                $items = [
                    'check_out_time' => '23:59:59',
                    'status' => '2'
                ];
                // table update
                Attendance::find($result['id'])->update($items);

                // 本日分のデータ登録
                $new_items = [
                    'user_id' => $user['id'],
                    'date' => $today,
                    'check_in_time' => '00:00:00',
                    'check_out_time' => null,
                    'status' => '1'
                ];
                // table create
                Attendance::create($new_items);

            }
        }
        // 再度本日の勤務情報を取得
        $data = Attendance::GetAttendance($user['id'], $today, false)->first();

        // 休憩情報を登録
        $rest_items = [
            'attendance_id' => $data['id'],
            'rest_start_time' => Carbon::now()->format('H:i:s'),
            'rest_end_time' => null
        ];
        // table create
        Rest::create($rest_items);
        // 勤務情報も更新する
        $items = [
            'status' => '3'
        ];
        Attendance::find($data['id'])->update($items);

        // view表示
        return redirect('/')->with('message', '休憩を開始しました');
    }

    // 休憩終了ボタン押下時処理
    public function update()
    {
        // ログイン中のユーザー取得
        $user = Auth::user();
        // 本日日付を取得
        $today = Carbon::now()->format('Y-m-d');
        // 本日日付の勤務データを取得
        $data = Attendance::GetAttendance($user['id'], $today, true)
                                ->where('status', '3')
                                ->first();
        // データが存在する場合
        if(!is_null($data)){
            // 更新したい休憩情報を取得する
            $rest_data = Rest::where('attendance_id', $data['id'])
                    ->whereNull('rest_end_time')
                    ->orderBy('id', 'DESC')
                    ->first();

            // 現在時刻を取得
            $time = Carbon::now()->format('H:i:s');
            // 休憩テーブルに勤務終了時間を登録
            $rest_items = [
                'rest_end_time' => $time
            ];
            Rest::find($rest_data['id'])->update($rest_items);
            // 勤務テーブルのstatusを更新
            $items = [
                'status' => '1'
            ];
            Attendance::find($data['id'])->update($items);

        }else{
            // 何もしない
        }
        // view表示
        return redirect('/')->with('message', '休憩を終了しました');
    }
}
