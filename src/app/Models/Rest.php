<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'rest_start_time',
        'rest_end_time',
    ];

    public static function getTotal($total_seconds)
    {
        // 秒数から時間、分、秒を計算
        $hours = floor($total_seconds / 3600);
        $minutes = floor(($total_seconds % 3600) / 60);
        $seconds = $total_seconds % 60;
        // 結果を表示
        $time = new Carbon($hours . ":" . $minutes . ":" . $seconds);
        $time = $time->format("H:i:s");

        return $time;

    }

    public function attendance()
    {
        return $this->belongsTo('App\Models\Attendance');
    }
}
