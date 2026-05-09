<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFund extends Model
{
    protected $fillable = ['class_name', 'amount', 'date_received', 'receipt_number', 'recorded_by'];
    
    public function recordedBy() { 
        return $this->belongsTo(User::class, 'recorded_by'); 
    }
    
    protected function casts(): array { 
        return ['date_received' => 'date', 'amount' => 'decimal:2']; 
    }
}
