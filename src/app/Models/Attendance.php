<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Rest;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status'
    ];

    /**
     * 勤務情報取得処理
     */
    public function scopeGetAttendance($query, $user_id, $date, $checkout)
    {
        $query->where('user_id', $user_id)
                ->where('date', $date);
        if($checkout){
            $query->whereNull('check_out_time');
        }
        $query->orderBy('updated_at', 'DESC')
                ->orderBy('id', 'DESC');
    }

    /**
     * 休憩時間、合計勤務時間取得処理
     */
    public static function getRestTimes($attendances)
    {

        foreach ($attendances as $attendance) {
            $rest_time = 0;

            foreach ($attendance['rest'] as $rest) {
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

        return $attendances;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function rest()
    {
        return $this->hasMany('App\Models\Rest');
    }

}
