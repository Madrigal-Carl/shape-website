<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class InstructorViewModal extends Component
{
    public $isOpen = false;
    public $instructor_id = null;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->instructor_id = $id;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->instructor_id = null;
    }

    public function render()
    {
        return view('livewire.instructor-view-modal');
    }
}
