<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use App\Models\Subject;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;

class CurriculumAddModal extends Component
{
    public $subjects;
    public $isOpen = false;
    public $add_name;
    public $add_grade_level;
    public $add_specialization;
    public $selectedSpecializations = [];
    public $add_description;
    public $add_subject;
    public $selectedSubjects = [];

    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->resetVariables();
        $this->isOpen = false;
    }

    public function resetVariables()
    {
        $this->reset([
            'add_name',
            'add_grade_level',
            'add_specialization',
            'selectedSpecializations',
            'add_description',
            'add_subject',
            'selectedSubjects',
        ]);
    }

    public function updatedAddSpecialization($value)
    {
        if ($value && !in_array($value, $this->selectedSpecializations)) {
            $this->selectedSpecializations[] = $value;
        }

        $this->add_specialization = '';
    }

    public function removeSpecialization($index)
    {
        unset($this->selectedSpecializations[$index]);
        $this->selectedSpecializations = array_values($this->selectedSpecializations);
    }

    public function updatedAddSubject($value)
    {
        if ($value && !in_array($value, $this->selectedSubjects)) {
            $this->selectedSubjects[] = $value;
        }

        $this->add_subject = '';
    }

    public function removeSubject($index)
    {
        unset($this->selectedSubjects[$index]);
        $this->selectedSubjects = array_values($this->selectedSubjects);
    }

    public function addCurriculum()
    {
        try {
            $this->validate([
                'add_name' => 'required|min:5|max:18',
                'add_grade_level' => 'required',
                'selectedSpecializations' => 'required|min:1',
                'add_description' => 'max:255',
                'selectedSubjects' => 'required|min:1',
            ], [
                'add_name.required' => 'Name is required.',
                'add_name.min' => 'Name must be at least 5 characters.',
                'add_name.max' => 'Name must not be more than 18 characters.',
                'add_grade_level.required' => 'Grade level is required.',
                'add_specialization.required' => 'At least one specialization is required.',
                'add_description.max' => 'Description must not exceed 255 characters.',
                'add_subject.required' => 'At least one subject is required.',
            ]);

        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon : 'error', title : $message);
        }

        $curriculum = Curriculum::create([
            'name' => $this->add_name,
            'grade_level' => $this->add_grade_level,
            'specialization' => $this->selectedSpecializations,
            'description' => $this->add_description ?? '',
        ]);

        foreach ($this->selectedSubjects as $subject) {
            $subj = Subject::where('name', $subject)->first();
            CurriculumSubject::create([
                'curriculum_id' => $curriculum->id,
                'subject_id' => $subj->id,
            ]);
        }

        Feed::create([
            'group' => 'curriculum',
            'title' => 'New Curriculum Created',
            'message' => "A new curriculum named '{$this->add_name}' has been created.",
        ]);

        $this->dispatch('swal-toast', icon : 'success', title : 'Curriculum has been created successfully.');
        return $this->closeModal();
    }

    public function mount()
    {
        $this->subjects = Subject::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.curriculum-add-modal');
    }
}
