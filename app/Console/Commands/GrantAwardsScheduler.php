<?php

namespace App\Console\Commands;

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
            'lessonSubjectStudents.lesson.quiz.studentQuizzes.logs',
            'lessonSubjectStudents.lesson.activityLessons.studentActivities.logs',
        ])->get();

        // Calculate Early Bird candidates once for all lessons
        $earlyBirdStudentIds = $this->getEarlyBirdStudentIds($students);

        foreach ($students as $student) {
            $awards = [];

            if ($this->isTopScorer($student, $students)) $awards[] = 'Top Scorer';
            if ($this->isQuizMaster($student, $students)) $awards[] = 'Quiz Master';
            if ($this->isConsistentPerformer($student)) $awards[] = 'Consistent Performer';
            if ($this->isActivityChampion($student)) $awards[] = 'Activity Champion';
            if ($this->isAllRounder($student)) $awards[] = 'All-Rounder';
            if (in_array($student->id, $earlyBirdStudentIds)) $awards[] = 'Early Bird';
            if ($this->isPersistentLearner($student, $students)) $awards[] = 'Persistent Learner';
            if ($this->isPerfectStreak($student)) $awards[] = 'Perfect Streak';

            // Limit to 3 awards per student
            $awards = array_slice($awards, 0, 3);

            // Grant/revoke awards
            foreach (['Top Scorer','Quiz Master','Consistent Performer','Activity Champion','All-Rounder','Early Bird','Persistent Learner','Perfect Streak'] as $awardName) {
                $this->grantOrRevokeAward($student, $awardName, in_array($awardName, $awards));
            }
        }

        $this->info('Award checks finished.');
    }

    private function getSchoolYear(): string
    {
        $now = now();
        $year = $now->year;
        return $now->month >= 6 ? $year . '-' . ($year + 1) : ($year - 1) . '-' . $year;
    }

    protected function grantOrRevokeAward(Student $student, string $awardName, bool $meetsCriteria)
    {
        $award = Award::firstOrCreate(['name' => $awardName]);
        $currentYear = $this->getSchoolYear();

        $alreadyHas = $student->awards()
            ->wherePivot('school_year', $currentYear)
            ->where('award_id', $award->id)
            ->exists();

        if ($meetsCriteria && !$alreadyHas) {
            $student->awards()->attach($award->id, ['school_year' => $currentYear]);
            Log::info("Granted {$awardName} ({$currentYear}) to {$student->full_name}");
        } elseif (!$meetsCriteria && $alreadyHas) {
            $student->awards()->detach($award->id);
            Log::info("Revoked {$awardName} ({$currentYear}) from {$student->full_name}");
        }
    }

    // Top Scorer: Highest average quiz score (ties included)
    protected function isTopScorer(Student $student, $students)
    {
        $averages = $students->map(function ($s) {
            $quizzes = $s->lessonSubjectStudents->pluck('lesson.quiz')->filter();
            if ($quizzes->isEmpty()) return 0;
            return $quizzes->map(function ($quiz) use ($s) {
                $sq = $quiz?->studentQuizzes()->where('student_id', $s->id)->first();
                return $sq?->score ?? 0;
            })->avg();
        });

        $sorted = $averages->sortDesc()->values();
        $top3Avg = $sorted->take(3)->last() ?? 0;
        $studentAvg = $averages[$student->getKey()] ?? 0;
        return $studentAvg >= $top3Avg && $studentAvg > 0;
    }

    // Quiz Master: Highest total quiz score (ties included)
    protected function isQuizMaster(Student $student, $students)
    {
        $totals = $students->map(function ($s) {
            $quizzes = $s->lessonSubjectStudents->pluck('lesson.quiz')->filter();
            if ($quizzes->isEmpty()) return 0;
            return $quizzes->map(function ($quiz) use ($s) {
                $sq = $quiz?->studentQuizzes()->where('student_id', $s->id)->first();
                return $sq?->score ?? 0;
            })->sum();
        });

        $sorted = $totals->sortDesc()->values();
        $top3Total = $sorted->take(3)->last() ?? 0;
        $studentTotal = $totals[$student->getKey()] ?? 0;
        return $studentTotal >= $top3Total && $studentTotal > 0;
    }

    // Consistent Performer: ≥80 in all quizzes AND ≥80% activities completed
    protected function isConsistentPerformer(Student $student)
    {
        $quizzes = $student->lessonSubjectStudents->map(fn($lss) => $lss->lesson->quiz)->filter();
        if ($quizzes->isEmpty()) return false;

        $allAbove80 = $quizzes->every(function ($quiz) use ($student) {
            $sq = $quiz?->studentQuizzes()->where('student_id', $student->id)->first();
            return $sq?->score >= 80;
        });

        $totalActivities = $student->getTotalActivitiesCountAttribute();
        $completedActivities = $student->getCompletedActivitiesCountAttribute();
        $activityRatio = $totalActivities > 0 ? $completedActivities / $totalActivities : 0;

        return $allAbove80 && $activityRatio >= 0.8;
    }

    // Activity Champion: All activities completed
    protected function isActivityChampion(Student $student)
    {
        $total = $student->getTotalActivitiesCountAttribute();
        $completed = $student->getCompletedActivitiesCountAttribute();
        return $total > 0 && $completed == $total;
    }

    // All-Rounder: All lessons completed
    protected function isAllRounder(Student $student)
    {
        $total = $student->getTotalLessonsCountAttribute();
        $completed = $student->getCompletedLessonsCountAttribute();
        return $total > 0 && $completed == $total;
    }

    // Early Bird: Earliest completed log for lessons, and ≥80% lessons completed
    protected function getEarlyBirdStudentIds($students)
    {
        $lessonIds = [];
        foreach ($students as $student) {
            foreach ($student->lessonSubjectStudents as $lss) {
                $lessonIds[$lss->lesson_id] = true;
            }
        }
        $lessonIds = array_keys($lessonIds);

        $earlyBirdIds = [];
        foreach ($lessonIds as $lessonId) {
            $logs = [];
            foreach ($students as $student) {
                $lss = $student->lessonSubjectStudents->where('lesson_id', $lessonId)->first();
                if ($lss && $lss->lesson->isCompletedByStudent($student->id)) {
                    $log = null;
                    if ($lss->lesson->quiz) {
                        $sq = $lss->lesson->quiz->studentQuizzes()->where('student_id', $student->id)->first();
                        $log = $sq?->logs()->where('status', 'completed')->orderBy('created_at')->first();
                    }
                    if (!$log) {
                        foreach ($lss->lesson->activityLessons as $al) {
                            $sa = $al->studentActivities()->where('student_id', $student->id)->first();
                            $log = $sa?->logs()->where('status', 'completed')->orderBy('created_at')->first();
                            if ($log) break;
                        }
                    }
                    if ($log) {
                        $logs[] = ['student_id' => $student->id, 'created_at' => $log->created_at];
                    }
                }
            }
            if (!empty($logs)) {
                usort($logs, fn($a, $b) => strtotime($a['created_at']) <=> strtotime($b['created_at']));
                $earlyBirdIds[] = $logs[0]['student_id'];
            }
        }

        // Only students who are early bird in at least one lesson and completed ≥80% lessons
        $counts = array_count_values($earlyBirdIds);
        $qualified = [];
        foreach ($students as $student) {
            $totalLessons = $student->getTotalLessonsCountAttribute();
            $completedLessons = $student->getCompletedLessonsCountAttribute();
            $ratio = $totalLessons > 0 ? $completedLessons / $totalLessons : 0;
            if ($ratio >= 0.8 && isset($counts[$student->id])) {
                $qualified[] = $student->id;
            }
        }
        return $qualified;
    }

    // Persistent Learner: Most attempts and finished lessons
    protected function isPersistentLearner(Student $student, $students)
    {
        $attempts = $students->map(function ($s) {
            $count = 0;
            foreach ($s->lessonSubjectStudents as $lss) {
                if ($lss->lesson->isCompletedByStudent($s->id)) {
                    if ($lss->lesson->quiz) {
                        $sq = $lss->lesson->quiz->studentQuizzes()->where('student_id', $s->id)->first();
                        $count += $sq?->logs()->count() ?? 0;
                    }
                    foreach ($lss->lesson->activityLessons as $al) {
                        $sa = $al->studentActivities()->where('student_id', $s->id)->first();
                        $count += $sa?->logs()->count() ?? 0;
                    }
                }
            }
            return $count;
        });

        $maxAttempts = $attempts->max();
        $studentAttempts = $attempts[$student->getKey()] ?? 0;
        return $studentAttempts == $maxAttempts && $studentAttempts > 0;
    }

    // Perfect Streak: 100% in all quizzes
    protected function isPerfectStreak(Student $student)
    {
        $quizzes = $student->lessonSubjectStudents->map(fn($lss) => $lss->lesson->quiz)->filter();
        if ($quizzes->isEmpty()) return false;
        return $quizzes->every(function ($quiz) use ($student) {
            $sq = $quiz?->studentQuizzes()->where('student_id', $student->id)->first();
            return $sq?->score == 100;
        });
    }
}
