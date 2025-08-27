<?php

namespace App\Livewire;

use App\Models\Feed;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\CurriculumSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CurriculumAddModal extends Component
{
    public $isOpen = false;
    public $specializations;

    public $add_name, $add_grade_level, $add_specialization, $add_description, $add_subject, $subjects, $grade_levels;

    public $selectedSpecializations = [], $selectedSubjects = [];

    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->dispatch('refresh')->to('curriculum-main');
        $this->dispatch('refresh')->to('curriculum-aside');
        $this->isOpen = false;
    }

    public function resetFields()
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
                'add_name' => 'required|min:5|max:24',
                'add_grade_level' => 'required',
                'add_description' => 'nullable|max:255',
                'selectedSpecializations' => 'required|min:1',
                'selectedSubjects' => 'required|min:1',
            ], [
                'add_name.required' => 'Name is required.',
                'add_name.min' => 'Name must be at least 5 characters.',
                'add_name.max' => 'Name must not be more than 24 characters.',
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
            'instructor_id' => Auth::user()->accountable->id,
            'name' => $this->add_name,
            'grade_level' => $this->add_grade_level,
            'description' => $this->add_description ?? '',
        ]);

        $curriculum->specializations()->attach($this->selectedSpecializations);

        foreach ($this->selectedSubjects as $subjectName) {
            $subject = Subject::where('name', $subjectName)->first();
            CurriculumSubject::create([
                'curriculum_id' => $curriculum->id,
                'subject_id' => $subject->id,
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
        $this->grade_levels = Student::where('instructor_id', Auth::user()->accountable->id)
            ->with('profile')
            ->get()
            ->pluck('profile.grade_level')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
        $this->specializations = Auth::user()->accountable->specializations;
    }

    public function render()
    {
        return view('livewire.curriculum-add-modal');
    }
}
