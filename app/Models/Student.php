<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'lrn',
        'disability_type',
        'support_need',
    ];

    protected $casts = [
        'birth_date' => 'date',
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

    public function totalLessonsCount($schoolYearId = null, $quarter = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::find($schoolYearId);

        $lessons = $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->map(fn($lss) => $lss->lesson);

        if ($quarter && $schoolYear) {
            $lessons = $lessons->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter));
        }

        return $lessons->count();
    }

    public function completedLessonsCount($schoolYearId = null, $quarter = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::find($schoolYearId);

        $lessons = $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->map(fn($lss) => $lss->lesson);

        if ($quarter && $schoolYear) {
            $lessons = $lessons->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter));
        }

        return $lessons->filter(fn($lesson) => $lesson->isCompletedByStudent($this->id))->count();
    }

    public function totalActivitiesCount($schoolYearId = null, $quarter = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::find($schoolYearId);

        $lessons = $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->map(fn($lss) => $lss->lesson);

        if ($quarter && $schoolYear) {
            $lessons = $lessons->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter));
        }

        return $lessons->sum(fn($lesson) => $lesson->activityLessons->count());
    }

    public function completedActivitiesCount($schoolYearId = null, $quarter = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::find($schoolYearId);

        $lessons = $this->lessonSubjectStudents()
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->whereHas('curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->map(fn($lss) => $lss->lesson);

        if ($quarter && $schoolYear) {
            $lessons = $lessons->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter));
        }

        return $lessons->sum(function ($lesson) {
            return $lesson->activityLessons->filter(function ($activityLesson) {
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

    public function enrollmentStatus($schoolYearId = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;

        $enrollment = $this->enrollments()
            ->where('school_year_id', $schoolYearId)
            ->first();

        return $enrollment?->status;
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
