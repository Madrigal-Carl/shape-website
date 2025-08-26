<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\On;

class StudentViewModal extends Component
{
    public $isOpen = false;
    public $student_id = null;
    public $student;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->student_id = $id;
        $this->isOpen = true;

        $this->student = Student::with('guardian', 'profile', 'permanentAddress', 'currentAddress', 'lessons')->find($id);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->student_id = null;
    }

    public function render()
    {
        return view('livewire.student-view-modal');
    }
}
