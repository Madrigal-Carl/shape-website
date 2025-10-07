<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use App\Models\Curriculum;
use App\Models\Instructor;
use App\Models\SchoolYear;

class AdminDashboardMain extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public $shouldOpenModal = false;
    public $school_year, $school_years;

    public function mount()
    {
        $this->school_year = now()->schoolYear()->id;

        $this->school_years = SchoolYear::orderBy('name')->get();
    }

    public function openQuarterModal()
    {
        $this->dispatch('openModal')->to('quarter-setup-modal');
    }

    public function render()
    {
        $latest = SchoolYear::latest('fourth_quarter_end')->first();

        if (!$latest || $latest->hasEnded()) {
            $this->shouldOpenModal = true;
        }

        // Students: Exclude transferred, dropped
        $studentQuery = Student::whereHas('enrollments', function ($q) {
            $q->where('school_year_id', $this->school_year)
                ->whereNotIn('status', ['transferred', 'dropped']);
        });

        $totalStudents = $studentQuery->count();
        $autismCount = (clone $studentQuery)->where('disability_type', 'autism spectrum disorder')->count();
        $hearingCount = (clone $studentQuery)->where('disability_type', 'hearing impaired')->count();
        $speechCount = (clone $studentQuery)->where('disability_type', 'speech disorder')->count();

        // Instructors: Exclude resigned, retired, terminated
        $instructorCount = Instructor::whereNotIn('status', ['resigned', 'retired', 'terminated'])->count();

        // Curriculums: Only active
        $curriculumCount = Curriculum::where('status', 'active')->count();

        return view('livewire.admin-dashboard-main', [
            'totalStudents'   => $totalStudents,
            'autismCount'     => $autismCount,
            'hearingCount'    => $hearingCount,
            'speechCount'     => $speechCount,
            'instructorCount' => $instructorCount,
            'curriculumCount' => $curriculumCount,
        ]);
    }
}
