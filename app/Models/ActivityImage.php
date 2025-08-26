<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'activity_id',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
