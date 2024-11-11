<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LunchReservation extends Model
{
    protected $fillable = [
        'user_id',
        'lunch_type',
        'start_date',
        'end_date'
    ];

    const LUNCH_TYPES = [
        1 => '普通食',
        2 => '減量食',
        3 => '大盛',
        4 => '特別食'
    ];

    const LUNCH_COLORS = [
        1 => '#4CAF50', // 緑
        2 => '#2196F3', // 青
        3 => '#F44336', // 赤
        4 => '#9C27B0'  // 紫
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
