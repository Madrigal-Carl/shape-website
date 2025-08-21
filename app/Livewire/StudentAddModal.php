<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class StudentAddModal extends Component
{
    public $step = 1;

    public $lrn, $first_name, $middle_name, $last_name, $birthdate, $sex, $grade_level, $disability, $description;
    public $barangay, $municipal, $province, $guardian_name, $guardian_email, $guardian_phone;
    public $curriculum, $account_email, $account_password;

    #[On('openModal')]
    public function openModal()
    {
        $this->step = 1;
    }

    public function nextStep()
    {
        $this->validateStep();

        if ($this->step < 3) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    protected function validateStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'lrn' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'birthdate' => 'required|date',
                'sex' => 'required',
                'grade_level' => 'required',
            ], [

            ]);
        }

        if ($this->step === 2) {
            $this->validate([
                'barangay' => 'required',
                'municipal' => 'required',
                'province' => 'required',
                'guardian_name' => 'required',
                'guardian_email' => 'required|email',
                'guardian_phone' => 'required',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'curriculum' => 'required',
                'account_email' => 'required|email',
                'account_password' => 'required|min:6',
            ]);
        }
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('student-main');
        $this->dispatch('refresh')->to('student-aside');
        $this->reset();
        $this->step = 0;
    }

    public function addStudent()
    {
        $this->validateStep();

        session()->flash('success', 'Enrollment completed!');
    }

    public function render()
    {
        return view('livewire.student-add-modal');
    }
}
