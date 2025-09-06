<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class StudentMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $status = 'all';
    public $listeners = ["refresh" => '$refresh'];
    public $school_year, $school_years;

    public function mount()
    {
        $this->school_year = now()->schoolYear();
    }

    public function openAddStudentModal()
    {
        $this->dispatch('openModal')->to('student-add-modal');
    }

    public function openEditStudentModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('student-edit-modal');
    }

    public function openViewStudentModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('student-view-modal');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Auth::user()->accountable
        ->students()
        ->whereHas('enrollments', function ($q) {
            $q->where('school_year', $this->school_year);
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

        $this->school_years = Student::where('instructor_id', Auth::user()->accountable->id)
        ->with('enrollments')
        ->get()
        ->pluck('enrollments.*.school_year')
        ->flatten()
        ->unique()
        ->sort()
        ->values();

        return view('livewire.student-main', compact('students'));
    }
}
