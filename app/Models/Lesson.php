<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'lesson_subject_id',
        'title',
        'description',
    ];

    public function curriculumSubject()
    {
        return $this->belongsTo(CurriculumSubject::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function activityLessons()
    {
        return $this->hasMany(ActivityLesson::class);
    }
}
