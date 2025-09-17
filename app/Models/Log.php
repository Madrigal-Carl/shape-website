<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_activity_id',
        'attempt_number',
        'score',
        'time_spent_seconds',
        'status',
    ];

    public function studentActivty()
    {
        return $this->belongsTo(StudentActivity::class);
    }
}
