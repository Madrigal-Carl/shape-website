<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'score',
        'description',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'item');
    }

    public function latestLog()
    {
        return $this->morphOne(Log::class, 'item')->latestOfMany();
    }

    public function progress()
    {
        return $this->morphMany(Progress::class, 'item');
    }

    public function latestProgress()
    {
        return $this->morphOne(Progress::class, 'item')->latestOfMany();
    }
}
