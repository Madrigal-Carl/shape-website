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
}
