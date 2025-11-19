<?php

namespace App\Console\Commands;

use App\Models\Lesson;
use App\Models\Student;
use App\Models\SchoolYear;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentProgressReportMail;

class SendStudentProgressReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-student-progress-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly progress reports to guardians of enrolled students';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentSchoolYear = SchoolYear::where('name', now()->year)->first();
        if (!$currentSchoolYear) {
            $this->warn("No current school year found.");
            return;
        }

        // get enrolled students this school year
        $students = Student::whereHas('enrollments', function ($q) use ($currentSchoolYear) {
            $q->where('school_year_id', $currentSchoolYear->id);
        })->with('guardian')->get();

        foreach ($students as $student) {
            if (!$student->guardian || !$student->guardian->email) {
                continue;
            }

            $quarter = $currentSchoolYear->currentQuarter();

            // Get all lessons assigned to the student for this school year
            $lessons = $student->lessons()
                ->with([
                    'gameActivityLessons',
                    'classActivities',
                ])
                ->where('school_year_id', $currentSchoolYear->id)
                ->get();
            $lessons = $lessons->filter(function ($lesson) use ($currentSchoolYear, $quarter) {
                return $lesson->isInQuarter($currentSchoolYear, $quarter);
            });

            $lessonProgress = [];

            foreach ($lessons as $lesson) {

                // total activities
                $totalActs =
                    $lesson->gameActivityLessons->count() +
                    $lesson->classActivities->count();

                // completed activities for this specific lesson
                $completedActs = $lesson->activityLessons->filter(function ($activity) use ($student) {
                    return $activity->studentActivities()
                        ->where('student_id', $student->id)
                        ->where('status', 'finished')
                        ->exists();
                })->count();

                $percentage = $totalActs > 0 ? round(($completedActs / $totalActs) * 100, 1) : 0;

                $lessonProgress[] = [
                    'lesson_title'   => $lesson->title,
                    'completed'      => $completedActs,
                    'total'          => $totalActs,
                    'percentage'     => $percentage,
                ];
            }

            Mail::to($student->guardian->email)->queue(
                new StudentProgressReportMail(
                    $student,
                    $lessonProgress,
                    $quarter
                )
            );

            $this->info("Sent report for {$student->full_name} to {$student->guardian->email}");
        }
    }
}
