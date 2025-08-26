<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class InstructorMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $listeners = ["refresh" => '$refresh'];

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
        return view('livewire.instructor-main');
    }
}
