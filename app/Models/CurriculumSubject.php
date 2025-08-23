<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurriculumSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'subject_id',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function lessonSubjects()
    {
        return $this->hasMany(LessonSubject::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            LessonSubject::class,
            'curriculum_subject_id',
            'lesson_subject_id',
            'id',
            'id'
        );
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            LessonSubject::class,
            'curriculum_subject_id', // FK on LessonSubject
            'id',                    // PK on Student
            'id',                    // PK on CurriculumSubject
            'student_id'             // FK on LessonSubject
        );
    }
}
