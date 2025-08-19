<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'category',
    ];

    protected $casts = [
        'category' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
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
