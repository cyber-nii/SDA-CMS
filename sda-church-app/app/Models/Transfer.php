<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $primaryKey = 'transfer_id';

    protected $fillable = [
        'member_id',
        'transfer_type',
        'from_church',
        'to_church',
        'request_date',
        'approval_date',
        'status',
        'notes',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
