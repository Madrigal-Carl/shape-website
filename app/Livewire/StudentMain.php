<?php

namespace App\Livewire;

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
        ->with([
            'profile'
        ])
        ->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->status !== 'all', function ($query) {
            $query->whereHas('profile', function ($q) {
                $q->where('status', $this->status);
            });
        })
        ->orderBy('first_name')
        ->paginate(10);



        return view('livewire.student-main', compact('students'));
    }
}
