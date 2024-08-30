<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\models\Rest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /*------------------------*/
    /* 打刻ページ表示
    /*------------------------*/
    public function index()
    {
        // ログイン中のユーザー情報取得
        $user = Auth::user();
        // 本日の日付取得
        $today = Carbon::now()->format('Y-m-d');

        // ログイン中のユーザーの現時点の勤怠のステータスを取得
        $result = Attendance::GetAttendance($user['id'], $today, false)->first();

        // データが存在する場合
        if($result){
            $status = $result['status'];
        // データが存在しない場合
        } else {
            // 昨日の日付取得
            $yesterday = Carbon::now()->subDay()->format('Y-m-d');
            // 1日前かつ勤務終了時間が入っていないデータを取得する
            $result = Attendance::GetAttendance($user['id'], $yesterday, true)->get();
            // statusを出勤「1」とみなす
            if(count($result) != 0){
                $status = '1';
            // statusを退勤「2」とみなす
            }else{
                $status = '2';
            }
        }
        return view('index', compact('user', 'status'));
    }

    /*------------------------*/
    /* 勤務開始ボタン押下時処理 
    /*------------------------*/
    public function store()
    {
        // ログイン中のユーザー取得
        $user = Auth::user();
        // 本日日付を取得
        $today = Carbon::now()->format('Y-m-d');
        // 現在時刻を取得
        $time = Carbon::now()->format('H:i:s');

        // attendanceテーブルに登録する配列
        $items = [
            'user_id' => $user['id'],
            'date' => $today,
            'check_in_time' => $time,
            'check_out_time' => null,
            'status' => '1'
        ];

        Attendance::create($items);

        return redirect('/')->with('message', '勤務を開始しました');
    }

    /*------------------------*/
    /* 勤務終了ボタン押下時処理
    /*------------------------*/
    public function update()
    {
        // ログイン中のユーザー取得
        $user = Auth::user();
        // 本日日付を取得
        $today = Carbon::now()->format('Y-m-d');
        // 本日日付の勤務データを取得
        $data = Attendance::GetAttendance($user['id'], $today, false)->first();

        // 本日の勤務データが存在する場合
        if(isset($data)){
            // 勤務終了時間がNULLの場合
            if(is_null($data['check_out_time'])){
                // 現在時刻を取得
                $time = Carbon::now()->format('H:i:s');
                // attendancesテーブルに登録する配列
                $items = [
                    'check_out_time' => $time,
                    'status' => '2'
                ];
                // 更新
                Attendance::GetAttendance($user['id'], $today, true)
                                ->first()
                                ->update($items);
            }else{
                // 何もしない
            }
        // 本日の勤務データが存在しない場合
        }else{
            // 1日前の日付を取得
            $yesterday = Carbon::now()->subDay()->format('Y-m-d');
            // 1日前の勤務終了していないデータがあるか
            $check = Attendance::GetAttendance($user['id'], $yesterday, true)->exists();

            // 1日前の勤務終了していないデータある場合
            if($check){
                $items = [
                    'check_out_time' => '23:59:59',
                    'status' => '2'
                ];
                // 1日前の勤務データ更新
                Attendance::GetAttendance($user['id'], $yesterday, true)->update($items);

                // 現在時刻を取得
                $time = Carbon::now()->format('H:i:s');
                // 本日分のデータ登録
                $new_items = [
                    'user_id' => $user['id'],
                    'date' => $today,
                    'check_in_time' => '00:00:00',
                    'check_out_time' => $time,
                    'status' => '2'
                ];
                // 登録処理
                Attendance::create($new_items);
            }
        }
        return redirect('/')->with('message', '勤務を終了しました');
    }

    /*------------------------*/
    /* 日付別勤怠ページ表示
    /*------------------------*/
    public function show()
    {
        //$date = Carbon::now()->format('Y-m-d');
        $date = '2024-08-27';

        $attendances = Attendance::with('rest', 'user')
                        ->where('date', $date)
                        ->orderBy('check_in_time', 'ASC')
                        ->orderBy('user_id', 'ASC')
                        ->Paginate(5);

        foreach($attendances as $attendance) {
            $rest_time = 0;

            foreach($attendance['rest'] as $rest) {
                // 休憩開始時間
                $rest_start_time = new Carbon($rest['rest_start_time']);
                // 休憩終了時間
                $rest_end_time = new Carbon($rest['rest_end_time']);
                // 差分の秒数を計算
                $rest_seconds = $rest_start_time->diffInSeconds($rest_end_time);
                // 休憩時間を足していく
                $rest_time = $rest_time + $rest_seconds;
            }

            // totalの休憩時間を計算
            $total_rests = Rest::getTotal($rest_time);
            // 休憩時間の合計を配列に格納
            $attendance['rest'] = [
                'total_rests' => $total_rests,
            ];

            // 勤務開始時間
            $check_in_time = new Carbon($attendance['check_in_time']);
            // 勤務終了時間
            $check_out_time = new Carbon($attendance['check_out_time']);
            // 差分の秒数を計算
            $work_seconds = $check_in_time->diffInSeconds($check_out_time);
            // 勤務時間合計を計算（勤務時間-休憩時間）
            $work_time = $work_seconds - $rest_time;
            // totalの勤務時間を計算
            $total_works = Rest::getTotal($work_time);
            // 勤務時間の合計を配列に格納
            $attendance['work'] = [
                'total_works' => $total_works,
            ];

        }
        return view('attendance', compact('date', 'attendances'));
    }
}
