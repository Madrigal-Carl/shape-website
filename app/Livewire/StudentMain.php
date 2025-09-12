<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use App\Models\Enrollment;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class StudentMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $grade_level = 'all';
    public $status = 'all';
    public $listeners = ["refresh" => '$refresh'];
    public $school_year, $school_years, $grade_levels;

    public function mount()
    {
        $this->school_year = now()->schoolYear();

        $this->school_years = Student::where('instructor_id', Auth::user()->accountable->id)
            ->with('enrollments')
            ->get()
            ->pluck('enrollments.*.school_year')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        $this->grade_levels = Enrollment::whereIn('student_id', Auth::user()->accountable->students->pluck('id'))
            ->pluck('grade_level')
            ->unique()
            ->sort()
            ->values();
    }

    public function openAddStudentModal()
    {
        $this->dispatch('openModal')->to('student-add-modal');
    }

    public function openMoveUpStudentModal()
    {
        $this->dispatch('openModal')->to('student-move-up-modal');
    }

    public function openEditStudentModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('student-edit-modal');
    }

    public function openViewStudentModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('student-view-modal');
    }

    public function render()
    {
        $students = Auth::user()->accountable
            ->students()
            ->whereHas('enrollments', function ($q) {
                $q->where('school_year', $this->school_year);
                if ($this->grade_level && $this->grade_level !== 'all') {
                    $q->where('grade_level', $this->grade_level);
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('first_name')
            ->paginate(10);

        return view('livewire.student-main', compact('students'));
    }
}
