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

    public function fourthQuarterHasEnded($schoolYearId = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;

        $enrollment = $this->enrollments()
            ->where('school_year_id', $schoolYearId)
            ->first();

        if (!$enrollment || !$enrollment->schoolYear) {
            return false; // not enrolled or school year missing
        }

        return $enrollment->schoolYear->hasEnded();
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

    public function studentActivities()
    {
        return $this->hasMany(StudentActivity::class);
    }

    public function activityStatus($activityLesson)
    {
        return $this->studentActivities()
            ->where('activity_lesson_type', get_class($activityLesson))
            ->where('activity_lesson_id', $activityLesson->id)
            ->value('status');
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

        // student's enrollment for that school year
        $enrollment = $this->enrollments()
            ->where('school_year_id', $schoolYearId)
            ->first();

        if (!$enrollment) return 0;

        $gradeLevelId = $enrollment->grade_level_id;
        $instructorId = $enrollment->instructor_id;
        $disability   = strtolower(trim($this->disability_type));

        // curriculums that match grade, instructor, active and include the student's specialization
        $curriculumIds = Curriculum::where('grade_level_id', $gradeLevelId)
            ->where('instructor_id', $instructorId)
            ->where('status', 'active')
            ->whereHas('specializations', function ($q) use ($disability) {
                $q->whereRaw('LOWER(name) = ?', [$disability]);
            })
            ->pluck('id');

        if ($curriculumIds->isEmpty()) return 0;

        // curriculum subjects that belong to those curriculums
        $curriculumSubjectIds = CurriculumSubject::whereIn('curriculum_id', $curriculumIds)
            ->pluck('id');

        if ($curriculumSubjectIds->isEmpty()) return 0;

        // lesson ids tied to those curriculum_subjects and the target school year
        $lessonIds = LessonSubjectStudent::whereIn('curriculum_subject_id', $curriculumSubjectIds)
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->pluck('lesson_id')
            ->unique()
            ->values();

        if ($lessonIds->isEmpty()) return 0;

        // optionally filter by quarter
        if ($quarter && $schoolYear) {
            $lessonIds = Lesson::whereIn('id', $lessonIds)
                ->get()
                ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter))
                ->pluck('id')
                ->values();
        }

        return $lessonIds->count();
    }

    public function totalActivitiesCount($schoolYearId = null, $quarter = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::find($schoolYearId);

        // enrollment check
        $enrollment = $this->enrollments()
            ->where('school_year_id', $schoolYearId)
            ->first();

        if (!$enrollment) return 0;

        $gradeLevelId = $enrollment->grade_level_id;
        $instructorId = $enrollment->instructor_id;
        $disability   = strtolower(trim($this->disability_type));

        // get curriculum ids that match constraints
        $curriculumIds = Curriculum::where('grade_level_id', $gradeLevelId)
            ->where('instructor_id', $instructorId)
            ->where('status', 'active')
            ->whereHas('specializations', function ($q) use ($disability) {
                $q->whereRaw('LOWER(name) = ?', [$disability]);
            })
            ->pluck('id');

        if ($curriculumIds->isEmpty()) return 0;

        $curriculumSubjectIds = CurriculumSubject::whereIn('curriculum_id', $curriculumIds)
            ->pluck('id');

        if ($curriculumSubjectIds->isEmpty()) return 0;

        // lesson ids in that curriculum and school year
        $lessonIds = LessonSubjectStudent::whereIn('curriculum_subject_id', $curriculumSubjectIds)
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->pluck('lesson_id')
            ->unique()
            ->values();

        if ($lessonIds->isEmpty()) return 0;

        // optional quarter filter
        if ($quarter && $schoolYear) {
            $lessonIds = Lesson::whereIn('id', $lessonIds)
                ->get()
                ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter))
                ->pluck('id')
                ->values();

            if ($lessonIds->isEmpty()) return 0;
        }

        // count game activity lessons and class activities attached to those lesson ids
        $gameCount = GameActivityLesson::whereIn('lesson_id', $lessonIds)->count();
        $classCount = ClassActivity::whereIn('lesson_id', $lessonIds)->count();

        return $gameCount + $classCount;
    }

    public function completedActivitiesCount($schoolYearId = null, $quarter = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::find($schoolYearId);

        // enrollment check
        $enrollment = $this->enrollments()
            ->where('school_year_id', $schoolYearId)
            ->first();

        if (!$enrollment) return 0;

        $gradeLevelId = $enrollment->grade_level_id;
        $instructorId = $enrollment->instructor_id;
        $disability   = strtolower(trim($this->disability_type));

        // curriculums
        $curriculumIds = Curriculum::where('grade_level_id', $gradeLevelId)
            ->where('instructor_id', $instructorId)
            ->where('status', 'active')
            ->whereHas('specializations', function ($q) use ($disability) {
                $q->whereRaw('LOWER(name) = ?', [$disability]);
            })
            ->pluck('id');

        if ($curriculumIds->isEmpty()) return 0;

        $curriculumSubjectIds = CurriculumSubject::whereIn('curriculum_id', $curriculumIds)
            ->pluck('id');

        if ($curriculumSubjectIds->isEmpty()) return 0;

        // lesson ids in that curriculum and school year
        $lessonIds = LessonSubjectStudent::whereIn('curriculum_subject_id', $curriculumSubjectIds)
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->pluck('lesson_id')
            ->unique()
            ->values();

        if ($lessonIds->isEmpty()) return 0;

        // optional quarter filter
        if ($quarter && $schoolYear) {
            $lessonIds = Lesson::whereIn('id', $lessonIds)
                ->get()
                ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter))
                ->pluck('id')
                ->values();

            if ($lessonIds->isEmpty()) return 0;
        }

        // get activity ids attached to those lessons
        $gameActivityLessonIds = GameActivityLesson::whereIn('lesson_id', $lessonIds)->pluck('id')->toArray();
        $classActivityIds = ClassActivity::whereIn('lesson_id', $lessonIds)->pluck('id')->toArray();

        // count finished student activities for this student where activity_lesson is either type & id in our lists
        $count = StudentActivity::where('student_id', $this->id)
            ->where('status', 'finished')
            ->where(function ($q) use ($gameActivityLessonIds, $classActivityIds) {
                if (!empty($gameActivityLessonIds)) {
                    $q->orWhere(function ($q2) use ($gameActivityLessonIds) {
                        $q2->where('activity_lesson_type', GameActivityLesson::class)
                            ->whereIn('activity_lesson_id', $gameActivityLessonIds);
                    });
                }
                if (!empty($classActivityIds)) {
                    $q->orWhere(function ($q3) use ($classActivityIds) {
                        $q3->where('activity_lesson_type', ClassActivity::class)
                            ->whereIn('activity_lesson_id', $classActivityIds);
                    });
                }
            })
            ->count();

        return $count;
    }

    public function completedLessonsCount($schoolYearId = null, $quarter = null)
    {
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::find($schoolYearId);

        // get lesson ids (same as totalLessonsCount)
        $enrollment = $this->enrollments()
            ->where('school_year_id', $schoolYearId)
            ->first();

        if (!$enrollment) return 0;

        $gradeLevelId = $enrollment->grade_level_id;
        $instructorId = $enrollment->instructor_id;
        $disability   = strtolower(trim($this->disability_type));

        $curriculumIds = Curriculum::where('grade_level_id', $gradeLevelId)
            ->where('instructor_id', $instructorId)
            ->where('status', 'active')
            ->whereHas('specializations', function ($q) use ($disability) {
                $q->whereRaw('LOWER(name) = ?', [$disability]);
            })
            ->pluck('id');

        if ($curriculumIds->isEmpty()) return 0;

        $curriculumSubjectIds = CurriculumSubject::whereIn('curriculum_id', $curriculumIds)
            ->pluck('id');

        if ($curriculumSubjectIds->isEmpty()) return 0;

        $lessonIds = LessonSubjectStudent::whereIn('curriculum_subject_id', $curriculumSubjectIds)
            ->whereHas('lesson', function ($q) use ($schoolYearId) {
                $q->where('school_year_id', $schoolYearId);
            })
            ->pluck('lesson_id')
            ->unique()
            ->values();

        if ($lessonIds->isEmpty()) return 0;

        if ($quarter && $schoolYear) {
            $lessonIds = Lesson::whereIn('id', $lessonIds)
                ->get()
                ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $quarter))
                ->pluck('id')
                ->values();

            if ($lessonIds->isEmpty()) return 0;
        }

        // load lesson models with their activities and student activities for the current student
        $lessons = Lesson::with([
            'gameActivityLessons.studentActivities' => function ($q) {
                $q->where('student_id', $this->id);
            },
            'classActivities.studentActivities' => function ($q) {
                $q->where('student_id', $this->id);
            }
        ])->whereIn('id', $lessonIds)->get();

        // a lesson is completed if every activity attached to the lesson has a finished StudentActivity for this student
        $completed = $lessons->filter(function ($lesson) {
            $allGameOk = $lesson->gameActivityLessons->every(function ($gal) {
                // if there are no studentActivities for this student for that gameActivityLesson, fail
                $sa = $gal->studentActivities->first();
                return $sa && $sa->status === 'finished';
            });

            $allClassOk = $lesson->classActivities->every(function ($ca) {
                $sa = $ca->studentActivities->first();
                return $sa && $sa->status === 'finished';
            });

            // if lesson has no activities at all, it's not considered completed
            $hasAny = $lesson->gameActivityLessons->isNotEmpty() || $lesson->classActivities->isNotEmpty();

            return $hasAny && $allGameOk && $allClassOk;
        });

        return $completed->count();
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
