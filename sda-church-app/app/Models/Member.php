<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'contact_number',
        'email',
        'address',
        'marital_status',
        'baptism_date',
        'status',
        'profile_picture',
    ];

    // Relationships
    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'member_departments',
            'member_id',       // foreign pivot key (points to this model)
            'department_id',  // related pivot key (points to Department)
            'member_id',       // local key on members table
            'department_id'   // local key on departments table
        );
    }

    public function tithes()
    {
        return $this->hasMany(Tithe::class, 'member_id', 'member_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'member_id', 'member_id');
    }

    public function baptisms()
    {
        return $this->hasMany(Baptism::class, 'member_id', 'member_id');
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'member_id', 'member_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'member_id', 'member_id');
    }
}
