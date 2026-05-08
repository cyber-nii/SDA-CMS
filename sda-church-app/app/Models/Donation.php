<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $primaryKey = 'donation_id';

    protected $fillable = [
        'member_id',
        'purpose',
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
