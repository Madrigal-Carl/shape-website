<?php

namespace App\Console\Commands;

use App\Models\Feed;
use App\Models\Award;
use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GrantAwardsScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:grant-awards-scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grants award to students who meet the criteria across instructor\'s curriculums';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking awards...');

        $students = Student::with([
            'lessonSubjectStudents.lesson.activityLessons.studentActivities.logs',
            'lessonSubjectStudents.curriculumSubject.subject',
        ])->get();

        $activityAceIds = $this->getActivityAceStudentIds($students);
        $resilientLearnerIds = $this->getResilientLearnerStudentIds($students);
        $progressPioneerIds = $this->getProgressPioneerStudentIds($students);
        $speedLearnerIds = $this->getSpeedLearnerStudentIds($students);

        foreach ($students as $student) {
            $awards = [];

            if (in_array($student->id, $activityAceIds)) $awards[] = 'Activity Ace';
            if ($this->isLessonFinisher($student)) $awards[] = 'Lesson Finisher';
            if (in_array($student->id, $resilientLearnerIds)) $awards[] = 'Resilient Learner';
            if (in_array($student->id, $progressPioneerIds)) $awards[] = 'Progress Pioneer';
            if ($this->isSubjectSpecialist($student)) $awards[] = 'Subject Specialist';
            if (in_array($student->id, $speedLearnerIds)) $awards[] = 'Speed Learner';

            foreach (['Activity Ace','Lesson Finisher','Resilient Learner','Progress Pioneer','Subject Specialist','Speed Learner'] as $awardName) {
                $this->grantOrRevokeAward($student, $awardName, in_array($awardName, $awards));
            }
        }

        $this->info('Award checks finished.');
    }

    protected function grantOrRevokeAward(Student $student, string $awardName, bool $meetsCriteria)
    {
        $award = Award::firstOrCreate(['name' => $awardName]);
        $currentYear = now()->schoolYear();

        $alreadyHas = $student->awards()
            ->wherePivot('school_year', $currentYear)
            ->where('award_id', $award->id)
            ->exists();

        if ($meetsCriteria && !$alreadyHas) {
            $student->awards()->attach($award->id, ['school_year' => $currentYear]);
            Feed::create([
                'notifiable_id' => $student->id,
                'group' => 'award',
                'title' => "{$student->fullname} earned a new award!",
                'message' => "{$student->fullname} has been awarded the '{$award->name}' for outstanding performance.",
            ]);
            Log::info("Granted {$awardName} ({$currentYear}) to {$student->full_name}");
        } elseif (!$meetsCriteria && $alreadyHas) {
            $student->awards()->detach($award->id);
            Feed::create([
                'notifiable_id' => $student->id,
                'group' => 'award',
                'title' => "Award revoked from {$student->fullname}",
                'message' => "The '{$award->name}' award has been revoked from {$student->fullname}.",
            ]);
            Log::info("Revoked {$awardName} ({$currentYear}) from {$student->full_name}");
        }
    }

        // Activity Ace: Top 3 students with most activities completed (ties included)
    protected function getActivityAceStudentIds($students)
    {
        $completedCounts = $students->mapWithKeys(function ($student) {
            return [$student->id => $student->getCompletedActivitiesCountAttribute()];
        });
        $sorted = $completedCounts->sortDesc();
        $topCounts = $sorted->take(3)->values();
        if ($topCounts->isEmpty() || $topCounts[0] == 0) return [];
        $minTop = $topCounts->last();
        return $completedCounts->filter(fn($count) => $count >= $minTop && $count > 0)->keys()->toArray();
    }

    // Lesson Finisher: All lessons completed
    protected function isLessonFinisher(Student $student)
    {
        $total = $student->getTotalLessonsCountAttribute();
        $completed = $student->getCompletedLessonsCountAttribute();
        return $total > 0 && $completed == $total;
    }

    // Resilient Learner: Top 3 students with most attempts before completing any activity, must have completed at least 50% of lessons
    protected function getResilientLearnerStudentIds($students)
    {
        $attempts = $students->mapWithKeys(function ($student) {
            $maxAttempts = 0;
            foreach ($student->lessonSubjectStudents as $lss) {
                foreach ($lss->lesson->activityLessons as $al) {
                    $sa = $al->studentActivities->where('student_id', $student->id)->first();
                    if ($sa) {
                        $logs = $sa->logs->sortBy('attempt_number');
                        $completedLog = $logs->where('status', 'completed')->first();
                        if ($completedLog) {
                            $maxAttempts = max($maxAttempts, $completedLog->attempt_number ?? 1);
                        }
                    }
                }
            }
            // Only consider if completed at least 50% of lessons
            $total = $student->getTotalLessonsCountAttribute();
            $completed = $student->getCompletedLessonsCountAttribute();
            $ratio = $total > 0 ? $completed / $total : 0;
            return [$student->id => ($ratio >= 0.5 ? $maxAttempts : 0)];
        });
        $sorted = $attempts->sortDesc();
        $topCounts = $sorted->take(3)->values();
        if ($topCounts->isEmpty() || $topCounts[0] == 0) return [];
        $minTop = $topCounts->last();
        return $attempts->filter(fn($count) => $count >= $minTop && $count > 0)->keys()->toArray();
    }

    // Progress Pioneer: Top 3 students with greatest average improvement (ties included)
    protected function getProgressPioneerStudentIds($students)
    {
        $improvements = $students->mapWithKeys(function ($student) {
            $totalImprovement = 0;
            $count = 0;
            foreach ($student->lessonSubjectStudents as $lss) {
                foreach ($lss->lesson->activityLessons as $al) {
                    $sa = $al->studentActivities->where('student_id', $student->id)->first();
                    if ($sa && $sa->logs->count() >= 2) {
                        $first = $sa->logs->sortBy('attempt_number')->first();
                        $last = $sa->logs->sortByDesc('attempt_number')->first();
                        $improvement = ($last->score ?? 0) - ($first->score ?? 0);
                        $totalImprovement += $improvement;
                        $count++;
                    }
                }
            }
            return [$student->id => $count > 0 ? $totalImprovement / $count : 0];
        });
        $sorted = $improvements->sortDesc();
        $topCounts = $sorted->take(3)->values();
        if ($topCounts->isEmpty() || $topCounts[0] == 0) return [];
        $minTop = $topCounts->last();
        return $improvements->filter(fn($val) => $val >= $minTop && $val > 0)->keys()->toArray();
    }

    // Subject Specialist: Completed every activity in any subject
    protected function isSubjectSpecialist(Student $student)
    {
        $subjects = $student->lessonSubjectStudents->pluck('curriculumSubject.subject')->unique('id')->filter();
        foreach ($subjects as $subject) {
            $allActivities = $subject->curriculumSubjects
                ->flatMap(fn($cs) => $cs->lessons)
                ->flatMap(fn($lesson) => $lesson->activityLessons);
            if ($allActivities->isEmpty()) continue;
            $allCompleted = $allActivities->every(function ($al) use ($student) {
                $sa = $al->studentActivities->where('student_id', $student->id)->first();
                if (!$sa) return false;
                $log = $sa->logs->sortByDesc('attempt_number')->first();
                return $log && $log->status === 'completed';
            });
            if ($allCompleted) return true;
        }
        return false;
    }

    // Speed Learner: Top 3 students with shortest total time, must have completed at least 50% of lessons
    protected function getSpeedLearnerStudentIds($students)
    {
        $times = $students->mapWithKeys(function ($student) {
            $totalTime = 0;
            foreach ($student->lessonSubjectStudents as $lss) {
                foreach ($lss->lesson->activityLessons as $al) {
                    $sa = $al->studentActivities->where('student_id', $student->id)->first();
                    if ($sa) {
                        $log = $sa->logs->where('status', 'completed')->sortByDesc('attempt_number')->first();
                        $totalTime += $log->time_spent_seconds ?? 0;
                    }
                }
            }
            // Only consider if completed at least 50% of lessons
            $total = $student->getTotalLessonsCountAttribute();
            $completed = $student->getCompletedLessonsCountAttribute();
            $ratio = $total > 0 ? $completed / $total : 0;
            return [$student->id => ($ratio >= 0.5 ? $totalTime : null)];
        })->filter(fn($t) => !is_null($t) && $t > 0);
        $sorted = $times->sort();
        $topCounts = $sorted->take(3)->values();
        if ($topCounts->isEmpty()) return [];
        $maxTop = $topCounts->last();
        return $times->filter(fn($t) => $t <= $maxTop)->keys()->toArray();
    }
}
