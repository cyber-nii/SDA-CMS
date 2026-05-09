<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baptism extends Model
{
    protected $primaryKey = 'baptism_id';

    protected $fillable = [
        'member_id',
        'baptism_date',
        'pastor_name',
        'location',
        'notes',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
