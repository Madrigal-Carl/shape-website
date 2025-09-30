<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\SchoolYear;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class InstructorViewModal extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $isOpen = false;
    public $instructor_id = null;
    public $instructor, $grade_level = '', $grade_levels, $school_year, $school_years;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->instructor_id = $id;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset();
    }

    public function render()
    {
        $this->school_year = now()->schoolYear()->id;
        $this->school_years = SchoolYear::orderBy('name')->get();

        if ($this->instructor_id) {
            $this->instructor = Instructor::with([
                'gradeLevels',
                'specializations',
                'permanentAddress',
                'currentAddress',
                'curriculums.curriculumSubjects.lessons',
            ])
                ->withCount([
                    'curriculums as curriculums_count' => fn($q) => $q->where('status', 'active')
                ])
                ->find($this->instructor_id);
        }

        $this->grade_levels = Enrollment::whereHas('student', fn($q) => $q->where('instructor_id', $this->instructor_id))
            ->where('school_year_id', $this->school_year)
            ->with('gradeLevel')
            ->get()
            ->pluck('gradeLevel')
            ->unique('id')
            ->sortBy('name')
            ->values();


        $students = collect();
        if ($this->instructor) {
            $students = $this->instructor->students()
                ->with(['enrollments' => fn($q) => $q->where('school_year_id', $this->school_year)])
                ->when(
                    $this->school_year,
                    fn($q) => $q->whereHas('enrollments', fn($sub) => $sub->where('school_year_id', $this->school_year))
                )
                ->when(
                    $this->grade_level && $this->grade_level !== 'all',
                    fn($q) => $q->whereHas('enrollments', fn($sub) => $sub->where('grade_level_id', $this->grade_level))
                )
                ->orderBy('first_name')
                ->paginate(10);
        }

        return view('livewire.instructor-view-modal', compact('students'));
    }
}
