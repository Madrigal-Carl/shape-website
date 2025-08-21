<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Profile;
use Livewire\Component;
use App\Models\Instructor;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudentAddModal extends Component
{
    public $step = 2;
    public $grade_levels = [], $specializations;
    public $lrn, $first_name, $middle_name, $last_name, $birthdate, $sex, $grade_level, $disability, $description;
    public $permanent_barangay, $permanent_municipal, $permanent_province,$current_barangay, $current_municipal, $current_province, $guardian_first_name, $guardian_middle_name, $guardian_last_name, $guardian_email, $guardian_phone;
    public $curriculum, $account_email, $account_password;

    #[On('openModal')]
    public function openModal()
    {
        $this->step = 1;
    }

    public function nextStep()
    {
        if ($this->validateStep()){
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
            try {
                $this->validate([
                'lrn' => 'required|digits:12',
                'first_name' => 'required',
                'middle_name' => 'required',
                'last_name' => 'required',
                'birthdate' => 'required|date|before_or_equal:today',
                'sex' => 'required',
                'grade_level' => 'required',
                'disability' => 'required',
                'description' => 'nullable|max:255',
                ], [
                'lrn.required'           => 'The LRN field is required.',
                'lrn.digits'             => 'The LRN must be exactly 12 digits.',
                'first_name.required'    => 'The first name is required.',
                'middle_name.required'   => 'The middle name is required.',
                'last_name.required'     => 'The last name is required.',
                'birthdate.required'     => 'The birthdate is required.',
                'birthdate.date'         => 'The birthdate must be a valid date.',
                'birthdate.before_or_equal' => 'The birthdate cannot be in the future.',
                'sex.required'           => 'Please select a sex.',
                'grade_level.required'   => 'The grade level is required.',
                'disability.required'    => 'Please specify the disability.',
                'description.max'   => 'The description is too long.',
                ]);
            } catch (ValidationException $e) {
                $message = $e->validator->errors()->first();
                $this->dispatch('swal-toast', icon : 'error', title : $message);
                return false;
            }
            return true;
        }

        if ($this->step === 2) {
            $this->validate([
                'barangay' => 'required',
                'municipal' => 'required',
                'province' => 'required',
                'guardian_name' => 'required',
                'guardian_email' => 'required|email',
                'guardian_phone' => 'nullable|regex:/^[0-9]{11}$/',
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
        $this->grade_levels = Profile::orderBy('grade_level')->pluck('grade_level')->unique()->values()->toArray();
        $user = Account::with('accountable')->find(Auth::user()->id);
        $this->specializations = $user->accountable->specialization;
        return view('livewire.student-add-modal');
    }
}
