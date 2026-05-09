<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $primaryKey = 'announcement_id';

    protected $fillable = [
        'title',
        'content',
        'publish_date',
        'expiry_date',
        'created_by',
    ];

    public function scopeActive($query)
    {
        return $query
            ->whereDate('publish_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhereDate('expiry_date', '>=', now());
            });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
