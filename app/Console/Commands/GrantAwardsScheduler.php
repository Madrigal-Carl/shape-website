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

        $this->checkTopScorerForAll();
        $this->checkQuizMasterForAll();

        $this->info('Award checks finished.');
    }

    private function getSchoolYear(): string
    {
        $now = now();
        $year = $now->year;

        if ($now->month >= 6) {
            return $year . '-' . ($year + 1);
        }
        return ($year - 1) . '-' . $year;
    }

    protected function grantOrRevokeAward(Student $student, string $awardName, bool $meetsCriteria)
    {
        $award = Award::firstOrCreate(['name' => $awardName]);
        $currentYear = $this->getSchoolYear();

        $alreadyHas = $student->awards()
            ->wherePivot('year', $currentYear)
            ->where('award_id', $award->id)
            ->exists();

        if ($meetsCriteria && !$alreadyHas) {
            // Grant award
            $student->awards()->attach($award->id, ['year' => $currentYear]);
            Log::info("Granted {$awardName} ({$currentYear}) to {$student->full_name}");
        } elseif (!$meetsCriteria && $alreadyHas) {
            // Revoke award
            $student->awards()->detach($award->id);
            Log::info("Revoked {$awardName} ({$currentYear}) from {$student->full_name}");
        }
    }

    protected function checkTopScorerForAll()
    {
        $academicYear = $this->getSchoolYear();

        // Get all students with their quizzes in the current academic year
        $students = Student::with([
            'lessonSubjectStudents.lesson.quiz' => function ($q) use ($academicYear) {
                $q->where('academic_year', $academicYear);
            }
        ])->get();

        // Compute averages
        $averages = $students->map(function ($student) {
            $quizzes = $student->lessonSubjectStudents
                ->pluck('lesson.quiz')
                ->filter();

            if ($quizzes->isEmpty()) {
                return ['student' => $student, 'avg' => 0];
            }

            $avg = $quizzes->map(function ($quiz) use ($student) {
                $sq = $quiz?->studentQuizzes()
                    ->where('student_id', $student->id)
                    ->first();
                return $sq?->score ?? 0;
            })->avg();

            return ['student' => $student, 'avg' => $avg];
        });

        // Sort by avg descending
        $sorted = $averages->sortByDesc('avg')->values();

        // Take top 3, then find the cutoff average (3rd place)
        $top3 = $sorted->take(3);
        $thirdPlaceAvg = $top3->last()['avg'] ?? 0;

        // Include ties with 3rd place
        $topScorers = $sorted->filter(function ($entry) use ($thirdPlaceAvg) {
            return $entry['avg'] >= $thirdPlaceAvg;
        });

        // Revoke award from everyone for this year
        foreach ($students as $student) {
            $this->grantOrRevokeAward($student, 'Top Scorer', false);
        }

        // Grant to top scorers (with ties included)
        foreach ($topScorers as $entry) {
            $this->grantOrRevokeAward($entry['student'], 'Top Scorer', true);
        }
    }

    protected function checkQuizMasterForAll()
    {
        $academicYear = $this->getSchoolYear();

        // Get all students with their quizzes in the current academic year
        $students = Student::with([
            'lessonSubjectStudents.lesson.quiz' => function ($q) use ($academicYear) {
                $q->where('academic_year', $academicYear);
            }
        ])->get();

        // Compute total quiz scores per student
        $totals = $students->map(function ($student) {
            $quizzes = $student->lessonSubjectStudents
                ->pluck('lesson.quiz')
                ->filter();

            if ($quizzes->isEmpty()) {
                return ['student' => $student, 'total' => 0];
            }

            $total = $quizzes->map(function ($quiz) use ($student) {
                $sq = $quiz?->studentQuizzes()
                    ->where('student_id', $student->id)
                    ->first();
                return $sq?->score ?? 0;
            })->sum();

            return ['student' => $student, 'total' => $total];
        });

        // Sort by total descending
        $sorted = $totals->sortByDesc('total')->values();

        // Take top 3, but allow ties
        $top3 = $sorted->take(3);
        $thirdPlaceScore = $top3->last()['total'] ?? 0;

        $topScorers = $sorted->filter(function ($entry) use ($thirdPlaceScore) {
            return $entry['total'] >= $thirdPlaceScore;
        });

        // Revoke award from everyone for this year
        foreach ($students as $student) {
            $this->grantOrRevokeAward($student, 'Quiz Master', false);
        }

        // Grant to top scorers (with ties included)
        foreach ($topScorers as $entry) {
            $this->grantOrRevokeAward($entry['student'], 'Quiz Master', true);
        }
    }




    // protected function checkQuizMaster(Student $student)
    // {
    //     $total = $student->lessonSubjectStudents->pluck('lesson.quiz')->filter()->sum(function ($quiz) use ($student) {
    //         $sq = $quiz->studentQuizzes()->where('student_id', $student->id)->first();
    //         return $sq ? $sq->logs()->latest('attempt_number')->value('score') : 0;
    //     });

    //     if ($total > 0) {
    //         $this->grantAward($student, 'Quiz Master');
    //     }
    // }

    // protected function checkConsistentPerformer(Student $student)
    // {
    //     $quizzes = $student->lessonSubjectStudents->pluck('lesson.quiz')->filter();
    //     if ($quizzes->isEmpty()) return;

    //     $consistent = $quizzes->every(function ($quiz) use ($student) {
    //         $sq = $quiz->studentQuizzes()->where('student_id', $student->id)->first();
    //         $score = $sq ? $sq->logs()->latest('attempt_number')->value('score') : 0;
    //         return $score >= 80;
    //     });

    //     if ($consistent) {
    //         $this->grantAward($student, 'Consistent Performer');
    //     }
    // }

    // protected function checkActivityChampion(Student $student)
    // {
    //     $completed = $student->completed_activities_count ?? 0;
    //     if ($completed >= 10) { // example threshold
    //         $this->grantAward($student, 'Activity Champion');
    //     }
    // }

    // protected function checkAllRounder(Student $student)
    // {
    //     if ($student->total_lessons_count == $student->completed_lessons_count) {
    //         $this->grantAward($student, 'All-Rounder');
    //     }
    // }

    // protected function checkPerfectStreak(Student $student)
    // {
    //     $quizzes = $student->lessonSubjectStudents->pluck('lesson.quiz')->filter();
    //     if ($quizzes->isEmpty()) return;

    //     $perfect = $quizzes->every(function ($quiz) use ($student) {
    //         $sq = $quiz->studentQuizzes()->where('student_id', $student->id)->first();
    //         $score = $sq ? $sq->logs()->latest('attempt_number')->value('score') : 0;
    //         return $score == 100;
    //     });

    //     if ($perfect) {
    //         $this->grantAward($student, 'Perfect Streak');
    //     }
    // }
}
