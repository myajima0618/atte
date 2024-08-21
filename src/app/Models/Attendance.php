<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function rest()
    {
        return $this->hasMany('App\Models\Rest');
    }

}
