<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    protected $primaryKey = 'expenditure_id';

    protected $fillable = [
        'expenditure_date',
        'title',
        'category',
        'amount',
        'payment_method',
        'description',
        'recorded_by',  // Kept for audit tracking — NOT displayed in UI table
    ];

    protected $casts = [
        'expenditure_date' => 'date',
        'amount'           => 'decimal:2',
    ];

    /**
     * Relationship to the User who recorded this entry (audit use only).
     */
    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
