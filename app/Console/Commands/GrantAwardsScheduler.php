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

        Instructor::with(['curriculums.curriculumSubjects.lessonSubjectStudents.student'])->chunk(2, function ($instructors) {
            foreach ($instructors as $instructor) {
                foreach ($instructor->students as $student) {

                    $this->checkTopScorer($student);
                    $this->checkQuizMaster($student);
                    $this->checkConsistentPerformer($student);
                    $this->checkActivityChampion($student);
                    $this->checkAllRounder($student);
                    $this->checkPerfectStreak($student);
                }
            }
        });

        $this->info('Award checks finished.');
    }

    private function getAcademicYear(): string
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
        $currentYear = $this->getAcademicYear();

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

    protected function checkTopScorer(Student $student)
    {
        $quizzes = $student->lessonSubjectStudents->pluck('lesson.quiz')->filter();
        if ($quizzes->isEmpty()) {
            $this->grantOrRevokeAward($student, 'Top Scorer', false);
            return;
        }

        $avg = $quizzes->map(function ($quiz) use ($student) {
            $sq = $quiz->studentQuizzes()
                ->where('student_id', $student->id)
                ->first();
            return $sq?->score ?? 0;
        })->avg();

        // Meets criteria if avg ≥ 90
        $this->grantOrRevokeAward($student, 'Top Scorer', $avg >= 90);
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
