<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'instructor_id',
        'path',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'lrn',
        'disability_type',
        'support_need',
        'status',
    ];

    public function getFullNameAttribute()
    {
        $middleInitial = $this->middle_name ? strtoupper(substr($this->middle_name, 0, 1)) . '.' : '';
        return "{$this->first_name} {$middleInitial} {$this->last_name}";
    }

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'owner');
    }

    public function permanentAddress()
    {
        return $this->morphOne(Address::class, 'owner')->where('type', 'permanent');
    }

    public function currentAddress()
    {
        return $this->morphOne(Address::class, 'owner')->where('type', 'current');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function isEnrolledIn($schoolYearId)
    {
        return $this->enrollments()
            ->where('school_year_id', $schoolYearId)
            ->first();
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function lessonSubjectStudents()
    {
        return $this->hasMany(LessonSubjectStudent::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            LessonSubjectStudent::class,
            'student_id',
            'id',
            'id',
            'lesson_id'
        );
    }

    public function totalAwardsCount($schoolYearId = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;

        return $this->studentAwards()
            ->where('school_year_id', $schoolYearId)
            ->count();
    }

    public function totalLessonsCount($schoolYearId = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;

        return $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->count();
    }

    public function completedLessonsCount($schoolYearId = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;

        return $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->filter(function ($lss) {
                return $lss->lesson->isCompletedByStudent($this->id);
            })
            ->count();
    }

    public function totalActivitiesCount($schoolYearId = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;

        return $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->sum(function ($lss) {
                return $lss->lesson->activityLessons->count();
            });
    }

    public function completedActivitiesCount($schoolYearId = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;

        return $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->sum(function ($lss) {
                return $lss->lesson->activityLessons->filter(function ($activityLesson) {
                    $studentActivity = $activityLesson->studentActivities()
                        ->where('student_id', $this->id)
                        ->first();

                    if (!$studentActivity) return false;

                    $log = $studentActivity->logs()
                        ->latest('attempt_number')
                        ->first();

                    return $log && $log->status === 'completed';
                })->count();
            });
    }

    public function studentAwards()
    {
        return $this->hasMany(StudentAward::class);
    }

    public function awards()
    {
        return $this->belongsToMany(Award::class, 'student_awards', 'student_id', 'award_id');
    }
}
