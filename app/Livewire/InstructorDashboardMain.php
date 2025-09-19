<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\Lesson;
use App\Models\ActivityLesson;
use App\Models\Curriculum;
use App\Models\StudentAward;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InstructorDashboardMain extends Component
{
    public $school_year, $school_years;

    // Dashboard stats
    public $totalStudents = 0;
    public $autismStudents = 0;
    public $hearingStudents = 0;
    public $speechStudents = 0;
    public $totalCurriculums = 0;
    public $totalLessons = 0;
    public $totalActivities = 0;
    public $totalAwards = 0;

    public function mount()
    {
        $instructorId = Auth::user()->accountable->id;
        $this->school_year = now()->schoolYear();

        // collect school years from enrollments
        $this->school_years = Student::where('instructor_id', $instructorId)
            ->with('enrollments')
            ->get()
            ->pluck('enrollments.*.school_year')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        $this->loadStats();
    }

    public function updatedSchoolYear()
    {
        $this->loadStats();
    }

    private function loadStats()
    {
        $instructorId = Auth::user()->accountable->id;

        $studentsQuery = Student::where('instructor_id', $instructorId)
            ->whereHas('enrollments', function ($q) {
                $q->where('school_year', $this->school_year);
            });

        $this->totalStudents   = $studentsQuery->count();
        $this->autismStudents  = (clone $studentsQuery)->where('disability_type', 'autism spectrum disorder')->count();
        $this->hearingStudents = (clone $studentsQuery)->where('disability_type', 'hearing impairment')->count();
        $this->speechStudents  = (clone $studentsQuery)->where('disability_type', 'speech disorder')->count();

        $this->totalCurriculums = Curriculum::where('instructor_id', $instructorId)
            ->where('status', 'active')
            ->count();

        $this->totalLessons = Lesson::where('school_year', $this->school_year)
            ->whereHas('lessonSubjectStudents.curriculumSubject.curriculum', function ($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId)->where('status', 'active');
            })
            ->count();

        $this->totalActivities = ActivityLesson::whereHas('lesson', function ($q) use ($instructorId) {
            $q->where('school_year', $this->school_year)
                ->whereHas('lessonSubjectStudents.curriculumSubject.curriculum', function ($cq) use ($instructorId) {
                    $cq->where('instructor_id', $instructorId)->where('status', 'active');
                });
        })->count();

        $this->totalAwards = StudentAward::whereHas('student', function ($q) use ($instructorId) {
            $q->where('instructor_id', $instructorId);
        })
            ->where('school_year', $this->school_year)
            ->count();
    }

    public function render()
    {
        return view('livewire.instructor-dashboard-main');
    }
}
