<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';


    protected $fillable = [
        'user_id',
        'stamp_date',
        'action',
        'start_time',
        'end_time',
        'break_start_time',
        'break_end_time',
    ];

    protected $dates = ['stamp_date']; // 日付として扱うべきカラムを指定

    public function user()
    {
        return $this->belongsTo(User::class);
    }




}



