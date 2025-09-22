<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Instructor;
use App\Models\Specialization;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class InstructorMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $listeners = ["refresh" => '$refresh'];

    public $specialization = 'all';
    public $search = '';

    public function openAddInstructorModal()
    {
        $this->dispatch('openModal')->to('instructor-add-modal');
    }

    public function openEditInstructorModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('instructor-edit-modal');
    }

    public function openViewInstructorModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('instructor-view-modal');
    }

    public function render()
    {
        $specializations = Specialization::orderBy('name')->get();

        $instructors = Instructor::with(['specializations', 'students'])
            ->when($this->specialization !== 'all' && $this->specialization !== '', function ($query) {
                $query->whereHas('specializations', function ($q) {
                    $q->where('id', $this->specialization);
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at')
            ->paginate(10);

        return view('livewire.instructor-main', compact('instructors', 'specializations'));
    }
}
