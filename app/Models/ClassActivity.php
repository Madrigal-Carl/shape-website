<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_subject_id',
        'instructor_id',
        'name',
        'description',
    ];

    public function curriculumSubject()
    {
        return $this->belongsTo(CurriculumSubject::class);
    }

    public function activityLesson()
    {
        return $this->morphMany(ActivityLesson::class, 'activity_lessonable');
    }

    public function studentActivities()
    {
        return $this->hasManyThrough(
            StudentActivity::class,   // final model
            ActivityLesson::class,    // intermediate
            'activity_lessonable_id', // foreign key on ActivityLesson
            'activity_lesson_id',     // foreign key on StudentActivity
            'id',                     // local key on ClassActivity
            'id'                      // local key on ActivityLesson
        )->where('activity_lessonable_type', self::class);
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'student_activities',
            'activity_lesson_id',
            'student_id'
        )
            ->join('activity_lessons', 'student_activities.activity_lesson_id', '=', 'activity_lessons.id')
            ->where('activity_lessons.activity_lessonable_type', self::class)
            ->where('activity_lessons.activity_lessonable_id', $this->id);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
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
