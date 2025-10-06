<?php

namespace App\Console\Commands;

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

            $completed = $student->completedActivitiesCount($currentSchoolYear->id);
            $total     = $student->totalActivitiesCount($currentSchoolYear->id);
            $remaining = max(0, $total - $completed);

            Mail::to($student->guardian->email)->queue(
                new StudentProgressReportMail($student, $completed, $remaining)
            );

            $this->info("Sent report for {$student->full_name} to {$student->guardian->email}");
        }
    }
}
