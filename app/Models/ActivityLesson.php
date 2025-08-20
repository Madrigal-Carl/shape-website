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
    ];

    public function logs()
    {
        return $this->morphMany(Log::class, 'item');
    }

    public function progress()
    {
        return $this->morphMany(Progress::class, 'item');
    }
}
