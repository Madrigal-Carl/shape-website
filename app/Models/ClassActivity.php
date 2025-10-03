<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'curriculum_subject_id',
        'instructor_id',
        'todo_id',
        'name',
        'description',
    ];

    public function curriculumSubject()
    {
        return $this->belongsTo(CurriculumSubject::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function relatedStudents()
    {
        return $this->studentActivities()
            ->with('student')
            ->get()
            ->pluck('student');
    }

    public function studentActivities()
    {
        return $this->hasMany(StudentActivity::class, 'activity_lesson_id')
            ->where('activity_lesson_type', self::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_activities', 'activity_lesson_id', 'student_id')
            ->where('student_activities.activity_lesson_type', self::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->school_year_id)) {
                $model->school_year_id = now()->schoolYear()?->id;
            }
        });
    }
}
