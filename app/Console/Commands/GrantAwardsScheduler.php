<?php

namespace App\Console\Commands;

use App\Models\Feed;
use App\Models\Award;
use App\Models\Student;
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

        $currentSchoolYear = now()->schoolYear();
        if (!$currentSchoolYear) {
            $this->error('No current school year found.');
            return;
        }

        // Only students enrolled this school year
        $students = Student::whereHas('enrollments', function ($q) use ($currentSchoolYear) {
            $q->where('school_year_id', $currentSchoolYear->id);
        })->get();

        // Calculate all award eligibility
        $lessonFinisherIds = $this->getLessonFinisherIds($students, $currentSchoolYear);
        $activityAceIds    = $this->getActivityAceIds($students, $currentSchoolYear, $lessonFinisherIds);
        $subjectSpecialistIds = $this->getSubjectSpecialistIds($students, $currentSchoolYear);
        $gameMasterIds     = $this->getGameMasterIds($students, $currentSchoolYear);
        $earlyBirdIds      = $this->getEarlyBirdIds($students, $currentSchoolYear);
        $consistencyAwardIds = $this->getConsistencyAwardIds($students, $currentSchoolYear);

        // Award logic
        foreach ($students as $student) {
            $awards = [];

            if (in_array($student->id, $lessonFinisherIds)) {
                $awards[] = 'Lesson Finisher';
            } elseif (in_array($student->id, $activityAceIds)) {
                $awards[] = 'Activity Ace';
            }

            if (in_array($student->id, $subjectSpecialistIds)) {
                $awards[] = 'Subject Specialist';
            }
            if (in_array($student->id, $gameMasterIds)) {
                $awards[] = 'Game Master';
            }
            if (in_array($student->id, $earlyBirdIds)) {
                $awards[] = 'Early Bird';
            }
            if (in_array($student->id, $consistencyAwardIds)) {
                $awards[] = 'Consistency Award';
            }

            // Grant or revoke each award
            foreach (
                [
                    'Activity Ace',
                    'Lesson Finisher',
                    'Subject Specialist',
                    'Game Master',
                    'Early Bird',
                    'Consistency Award'
                ] as $awardName
            ) {
                $this->grantOrRevokeAward($student, $awardName, in_array($awardName, $awards), $currentSchoolYear->id);
            }
        }

        $this->info('Award checks finished.');
    }

    protected function grantOrRevokeAward($student, $awardName, $meetsCriteria, $schoolYearId)
    {
        $award = Award::firstOrCreate(['name' => $awardName]);
        $alreadyHas = $student->studentAwards()
            ->where('award_id', $award->id)
            ->where('school_year_id', $schoolYearId)
            ->exists();

        if ($meetsCriteria && !$alreadyHas) {
            $student->studentAwards()->create([
                'award_id' => $award->id,
                'school_year_id' => $schoolYearId,
            ]);
            Feed::create([
                'notifiable_id' => $student->id,
                'group' => 'award',
                'title' => "{$student->full_name} earned a new award!",
                'message' => "{$student->full_name} has been awarded the '{$award->name}' for outstanding performance.",
            ]);
        } elseif (!$meetsCriteria && $alreadyHas) {
            $student->studentAwards()
                ->where('award_id', $award->id)
                ->where('school_year_id', $schoolYearId)
                ->delete();
            Feed::create([
                'notifiable_id' => $student->id,
                'group' => 'award',
                'title' => "Award revoked from {$student->full_name}",
                'message' => "The '{$award->name}' award has been revoked from {$student->full_name}.",
            ]);
        }
    }

    // Lesson Finisher: completed all activities assigned (from active curriculums)
    protected function getLessonFinisherIds($students, $schoolYear)
    {
        return $students->filter(function ($student) use ($schoolYear) {
            $total = $student->totalActivitiesCount($schoolYear->id);
            $completed = $student->completedActivitiesCount($schoolYear->id);
            return $total > 0 && $completed == $total;
        })->pluck('id')->toArray();
    }

    // Activity Ace: Top 3 (with ties), excluding lesson finishers (from active curriculums)
    protected function getActivityAceIds($students, $schoolYear, $lessonFinisherIds)
    {
        $filtered = $students->filter(fn($s) => !in_array($s->id, $lessonFinisherIds));
        $counts = $filtered->mapWithKeys(fn($s) => [$s->id => $s->completedActivitiesCount($schoolYear->id)]);
        $sorted = $counts->sortDesc();
        $topCounts = $sorted->take(3)->values();
        if ($topCounts->isEmpty() || $topCounts[0] == 0) return [];
        $minTop = $topCounts->last();
        return $counts->filter(fn($count) => $count >= $minTop && $count > 0)->keys()->toArray();
    }

    // Subject Specialist: finished all activities in any subject (from active curriculums)
    protected function getSubjectSpecialistIds($students, $schoolYear)
    {
        $ids = [];
        foreach ($students as $student) {
            // Get all subjects for this student in active curriculums for the school year
            $subjects = $student->lessonSubjectStudents()
                ->whereHas('lesson', fn($q) => $q->where('school_year_id', $schoolYear->id))
                ->whereHas('curriculum', fn($q) => $q->where('status', 'active'))
                ->get()
                ->map(fn($lss) => $lss->curriculumSubject->subject)
                ->unique('id')
                ->filter();

            foreach ($subjects as $subject) {
                // Get all curriculum subjects for this subject in active curriculums
                $activeCurriculumSubjects = $subject->curriculumSubjects()
                    ->whereHas('curriculum', fn($q) => $q->where('status', 'active'))
                    ->get();

                // Get all lessons for these curriculum subjects in the school year
                $allLessons = $activeCurriculumSubjects
                    ->flatMap(
                        fn($cs) => $cs->lessonSubjectStudents()
                            ->whereHas('lesson', fn($q) => $q->where('school_year_id', $schoolYear->id))
                            ->get()
                            ->map(fn($lss) => $lss->lesson)
                    )
                    ->unique('id');

                // Get all activities for these lessons
                $allActivities = $allLessons
                    ->flatMap(fn($lesson) => $lesson->activityLessons);

                if ($allActivities->isEmpty()) continue;
                $allCompleted = $allActivities->every(function ($al) use ($student) {
                    $sa = $al->studentActivities()->where('student_id', $student->id)->where('status', 'finished')->first();
                    return $sa !== null;
                });
                if ($allCompleted) {
                    $ids[] = $student->id;
                    break;
                }
            }
        }
        return array_unique($ids);
    }

    // Game Master: finished all GameActivities (from active curriculums)
    protected function getGameMasterIds($students, $schoolYear)
    {
        // Get all GameActivityLesson for lessons in the current school year and active curriculums
        $gameActivityLessons = \App\Models\GameActivityLesson::whereHas('lesson.lessonSubjectStudents.curriculumSubject.curriculum', function ($q) {
            $q->where('status', 'active');
        })
            ->whereHas('lesson', function ($q) use ($schoolYear) {
                $q->where('school_year_id', $schoolYear->id);
            })
            ->get();

        return $students->filter(function ($student) use ($gameActivityLessons) {
            if ($gameActivityLessons->isEmpty()) return false;
            foreach ($gameActivityLessons as $gal) {
                $sa = $gal->studentActivities()
                    ->where('student_id', $student->id)
                    ->where('status', 'finished')
                    ->first();
                if (!$sa) {
                    return false;
                }
            }
            return true;
        })->pluck('id')->toArray();
    }

    // Early Bird: Top 3 (with ties) by earliest average completion time (from active curriculums)
    protected function getEarlyBirdIds($students, $schoolYear)
    {
        $avgTimes = $students->mapWithKeys(function ($student) use ($schoolYear) {
            $activities = $student->lessonSubjectStudents()
                ->whereHas('lesson', fn($q) => $q->where('school_year_id', $schoolYear->id))
                ->whereHas('curriculum', fn($q) => $q->where('status', 'active'))
                ->get()
                ->flatMap(fn($lss) => $lss->lesson->activityLessons ?? []);
            $times = $activities->map(function ($al) use ($student) {
                $sa = $al->studentActivities->where('student_id', $student->id)->first();
                return $sa && $sa->status === 'finished' ? $sa->updated_at->timestamp - $al->created_at->timestamp : null;
            })->filter();
            return [$student->id => $times->count() ? $times->avg() : null];
        })->filter();

        $sorted = $avgTimes->sort();
        $top = $sorted->take(3)->values();
        if ($top->isEmpty()) return [];
        $maxTop = $top->last();
        return $avgTimes->filter(fn($avg) => $avg !== null && $avg <= $maxTop)->keys()->toArray();
    }

    // Consistency Award: Top 3 (with ties) who finish all activities each week (from active curriculums)
    protected function getConsistencyAwardIds($students, $schoolYear)
    {
        $weekCounts = $students->mapWithKeys(function ($student) use ($schoolYear) {
            $weeks = [];
            $activities = $student->lessonSubjectStudents()
                ->whereHas('lesson', fn($q) => $q->where('school_year_id', $schoolYear->id))
                ->whereHas('curriculum', fn($q) => $q->where('status', 'active'))
                ->get()
                ->flatMap(fn($lss) => $lss->lesson->activityLessons ?? []);
            foreach ($activities as $al) {
                $week = $al->created_at->format('W');
                $weeks[$week] = $weeks[$week] ?? [];
                $weeks[$week][] = $al;
            }
            $consistentWeeks = 0;
            foreach ($weeks as $week => $als) {
                $allDone = collect($als)->every(function ($al) use ($student) {
                    $sa = $al->studentActivities->where('student_id', $student->id)->first();
                    return $sa && $sa->status === 'finished';
                });
                if ($allDone && count($als) > 0) $consistentWeeks++;
            }
            return [$student->id => $consistentWeeks];
        });
        $sorted = $weekCounts->sortDesc();
        $top = $sorted->take(3)->values();
        if ($top->isEmpty() || $top[0] == 0) return [];
        $minTop = $top->last();
        return $weekCounts->filter(fn($count) => $count >= $minTop && $count > 0)->keys()->toArray();
    }
}
