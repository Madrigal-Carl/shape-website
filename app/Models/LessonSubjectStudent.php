<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonSubjectStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_subject_id',
        'lesson_id',
        'student_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function curriculumSubject()
    {
        return $this->belongsTo(CurriculumSubject::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function quizzes()
    {
        return $this->hasManyThrough(
            Quiz::class,
            Lesson::class,
            'id',
            'lesson_id',
            'lesson_id',
            'id'
        );
    }

    public function activities()
    {
        return $this->hasManyThrough(
            Activity::class,
            Lesson::class,
            'id',
            'lesson_id',
            'lesson_id',
            'id'
        );
    }
}
