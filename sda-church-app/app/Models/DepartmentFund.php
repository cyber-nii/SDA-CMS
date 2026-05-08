<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentFund extends Model
{
    protected $fillable = ['department_id', 'amount', 'date_received', 'receipt_number', 'recorded_by'];

    public function department() { 
        return $this->belongsTo(Department::class, 'department_id', 'department_id'); 
    }
    
    public function recordedBy() { 
        return $this->belongsTo(User::class, 'recorded_by'); 
    }
    
    protected function casts(): array { 
        return ['date_received' => 'date', 'amount' => 'decimal:2']; 
    }
}
