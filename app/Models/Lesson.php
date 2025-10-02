<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function lessonSubjectStudents()
    {
        return $this->hasMany(LessonSubjectStudent::class);
    }

    public function activityLessons()
    {
        return $this->hasMany(ActivityLesson::class);
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            LessonSubjectStudent::class,
            'lesson_id',
            'id',
            'id',
            'student_id'
        );
    }
    public function isCompletedByStudent($studentId)
    {
        foreach ($this->activityLessons as $activityLesson) {
            $studentActivity = $activityLesson->studentActivities()
                ->where('student_id', $studentId)
                ->first();

            if (!$studentActivity || $studentActivity->status !== 'finished') {
                return false;
            }
        }

        return true;
    }


    public function isInQuarter(SchoolYear $schoolYear, int $quarter): bool
    {
        $date = $this->created_at;

        switch ($quarter) {
            case 1:
                return $date->between($schoolYear->first_quarter_start, $schoolYear->first_quarter_end);
            case 2:
                return $date->between($schoolYear->second_quarter_start, $schoolYear->second_quarter_end);
            case 3:
                return $date->between($schoolYear->third_quarter_start, $schoolYear->third_quarter_end);
            case 4:
                return $date->between($schoolYear->fourth_quarter_start, $schoolYear->fourth_quarter_end);
            default:
                return false;
        }
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
