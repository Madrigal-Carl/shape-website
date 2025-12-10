<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\ClassRecordHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClassRecordModal extends Component
{
    public $isOpen = false;
    public $selectedDisability = null;
    public $grade_levels, $grade_level_id = '';
    public $specializations = [];

    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->specializations = Auth::user()->accountable->specializations()->get();
    }

    public function closeModal()
    {
        $this->reset();
    }

    public function exportClassRecord()
    {
        try {
            $this->validate([
                'selectedDisability' => 'required',
                'grade_level_id' => 'required',
            ], [
                'selectedDisability.required' => 'Disability is required.',
                'grade_level_id.required' => 'Grade level is required.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon: 'error', title: $message);
        }

        $helper = new ClassRecordHelper();
        return $helper->generateClassRecord(Auth::user()->accountable->id, $this->selectedDisability, $this->grade_level_id);
    }

    public function render()
    {
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        return view('livewire.class-record-modal');
    }
}
