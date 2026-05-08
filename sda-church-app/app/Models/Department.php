<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'department_id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function members()
    {
        return $this->belongsToMany(
            Member::class,
            'member_departments',
            'department_id',  // foreign pivot key (points to this model)
            'member_id',       // related pivot key (points to Member)
            'department_id',  // local key on departments table
            'member_id'        // local key on members table
        );
    }
}
