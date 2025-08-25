<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'lesson_id',
        'score',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'item');
    }
}
