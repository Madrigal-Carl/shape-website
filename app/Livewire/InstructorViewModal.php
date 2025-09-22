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

        $this->instructor = Instructor::with([
            'specializations',
            'permanentAddress',
            'currentAddress',
            'curriculums.curriculumSubjects.lessons',
        ])
            ->withCount([
                'curriculums as curriculums_count' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->findOrFail($id);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->instructor_id = null;
        $this->instructor = null;
    }

    public function mount()
    {
        $this->school_year = now()->schoolYear()->id;

        $this->school_years = SchoolYear::orderBy('name')->get();
    }

    public function getStudentsProperty()
    {
        if (!$this->instructor) {
            return collect();
        }

        return $this->instructor->students()
            ->when($this->school_year, function ($q) {
                $q->whereHas(
                    'enrollments',
                    fn($sub) =>
                    $sub->where('school_year_id', $this->school_year)
                );
            })
            ->when($this->grade_level && $this->grade_level !== 'all', function ($q) {
                $q->whereHas(
                    'enrollments',
                    fn($sub) =>
                    $sub->where('grade_level', $this->grade_level)
                );
            })
            ->orderBy('first_name')
            ->paginate(10);
    }

    public function render()
    {
        // ... grade_levels logic ...
        if ($this->instructor) {
            $this->grade_levels = Enrollment::whereHas('student', function ($q) {
                $q->where('instructor_id', $this->instructor_id);
            })
                ->where('school_year_id', $this->school_year)
                ->pluck('grade_level')
                ->unique()
                ->sort()
                ->values();
        }
        return view('livewire.instructor-view-modal');
    }
}
