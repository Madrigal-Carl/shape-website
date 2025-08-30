<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'loggable_id',
        'loggable_type',
        'attempt_number',
        'time_spent_seconds',
        'status',
    ];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
