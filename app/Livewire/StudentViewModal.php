<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\On;

class StudentViewModal extends Component
{
    public $isOpen = false;
    public $student_id = null;
    public $school_year = null;
    public $student;

    #[On('openModal')]
    public function openModal($id, $school_year)
    {
        $this->student_id = $id;
        $this->school_year = $school_year;
        $this->isOpen = true;

        $this->student = Student::with('guardian', 'permanentAddress', 'currentAddress', 'lessons')->find($id);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->student_id = null;
        $this->school_year = null;
    }

    public function render()
    {
        return view('livewire.student-view-modal');
    }
}
