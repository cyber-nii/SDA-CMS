<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    protected $primaryKey = 'offering_id';

    protected $fillable = [
        'category',
        'amount',
        'date_received',
        'recorded_by',
    ];

    protected $casts = [
        'date_received' => 'date',
    ];

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
