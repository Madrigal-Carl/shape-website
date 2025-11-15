<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class StudentMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $grade_level = '';
    public $disability = '';
    public $status = 'all';
    public $listeners = ["refresh" => '$refresh'];
    public $school_year, $school_years, $grade_levels, $disabilities;

    public function mount()
    {
        $this->school_year = now()->schoolYear()->id;

        $this->school_years = SchoolYear::orderBy('name')->get();
    }

    public function openAddStudentModal()
    {
        $this->dispatch('openModal')->to('student-add-modal');
    }

    public function openAdvanceStudentModal()
    {
        $this->dispatch('openModal')->to('student-advance-modal');
    }

    public function openAddOldStudentModal()
    {
        $this->dispatch('openModal')->to('student-add-old-modal');
    }

    public function openEditStudentModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('student-edit-modal');
    }

    public function openViewStudentModal($id)
    {
        $this->dispatch('openModal', id: $id, school_year: $this->school_year)->to('student-view-modal');
    }

    public function render()
    {
        $students = Auth::user()->accountable
            ->students()
            ->whereHas('enrollments', function ($q) {
                $q->where('school_year_id', $this->school_year);

                if ($this->grade_level && $this->grade_level !== 'all') {
                    $q->where('grade_level_id', $this->grade_level);
                }

                if ($this->status !== 'all') {
                    $q->where('status', $this->status);
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->disability && $this->disability !== 'all', function ($query) {
                $specialization = Auth::user()->accountable
                    ->specializations()
                    ->find($this->disability);

                if ($specialization) {
                    $query->whereRaw('LOWER(disability_type) = ?', [strtolower($specialization->name)]);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        $this->disabilities = Auth::user()->accountable->specializations;
        return view('livewire.student-main', compact('students'));
    }
}
