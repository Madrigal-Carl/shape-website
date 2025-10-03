<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameActivityLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'game_activity_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function gameActivity()
    {
        return $this->belongsTo(GameActivity::class);
    }

    public function studentActivities()
    {
        return $this->morphMany(StudentActivity::class, 'activity_lesson');
    }
}
