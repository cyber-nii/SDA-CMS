<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tithe extends Model
{
    protected $primaryKey = 'tithe_id';

    protected $fillable = [
        'member_id',
        'amount',
        'date_received',
        'receipt_number',
        'recorded_by',
    ];

    protected $casts = [
        'date_received' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
