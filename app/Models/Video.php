<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'video_url',
        'thumbnail_url',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
