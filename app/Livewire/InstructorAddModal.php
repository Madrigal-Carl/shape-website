<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class InstructorAddModal extends Component
{
    public $step = 0;

    #[On('openModal')]
    public function openModal()
    {
        $this->step = 1;
    }

    public function nextStep()
    {
        // if ($this->validateStep()){
        //     $this->step++;
        // }
        $this->step++;
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function closeModal()
    {
        // $this->resetFields();
        $this->dispatch('refresh')->to('instructor-main');
        $this->dispatch('refresh')->to('instructor-aside');
        $this->step = 0;
    }

    public function addInstructor()
    {

    }

    public function render()
    {
        return view('livewire.instructor-add-modal');
    }
}
