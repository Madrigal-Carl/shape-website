<?php

namespace App\Livewire;

use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\CurriculumSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CurriculumEditModal extends Component
{
    public $isOpen = false, $curriculum_id = null, $specializations, $grade_levels;
    public $showSpecializationDropdown = false;
    public $showSubjectDropdown = false;
    public $subjects, $edit_name, $edit_grade_level = '', $edit_specialization, $edit_description, $edit_subject;
    public $selectedSpecializations = [], $selectedSubjects = [], $original = [];


    #[On('openModal')]
    public function openModal($id)
    {
        $this->curriculum_id = $id;
        $this->isOpen = true;

        $curriculum = Curriculum::with('specializations', 'curriculumSubjects.subject')->find($this->curriculum_id);

        $this->edit_name = $curriculum->name;
        $this->edit_grade_level = $curriculum->grade_level_id;
        $this->edit_description = $curriculum->description;
        $this->selectedSpecializations = $curriculum->specializations->pluck('id')->toArray();

        $this->selectedSubjects = $curriculum->curriculumSubjects->pluck('subject.name')->toArray();

        $this->original = [
            'name'           => $this->edit_name,
            'grade_level'    => $this->edit_grade_level,
            'description'    => $this->edit_description,
            'specialization' => $this->selectedSpecializations,
            'subjects'       => $this->selectedSubjects,
        ];
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('curriculum-main');
        $this->dispatch('refresh')->to('curriculum-aside');
        $this->isOpen = false;
    }

    public function clearSpecializations()
    {
        $this->selectedSpecializations = [];
    }

    public function clearSubjects()
    {
        $this->selectedSubjects = [];
    }

    public function editCurriculum()
    {
        try {
            $this->validate([
                'edit_name'              => 'required|min:5|max:30',
                'edit_grade_level'       => 'required',
                'edit_description' => 'nullable|max:255',
                'selectedSpecializations' => 'required|min:1',
                'selectedSubjects'        => 'required|min:1',
            ], [
                'edit_name.required' => 'Name is required.',
                'edit_name.min' => 'Name must be at least 5 characters.',
                'edit_name.max' => 'Name must not be more than 24 characters.',
                'edit_grade_level.required' => 'Grade level is required.',
                'edit_description.max' => 'Description must not exceed 255 characters.',
                'selectedSpecializations.required' => 'Please select at least one specialization.',
                'selectedSpecializations.min' => 'You must select at least one specialization.',
                'selectedSubjects.required' => 'Please select at least one subject.',
                'selectedSubjects.min' => 'You must select at least one subject.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
            return false;
        }


        $changes = collect([
            'name'           => [$this->edit_name, $this->original['name']],
            'grade_level'    => [$this->edit_grade_level, $this->original['grade_level']],
            'description'    => [$this->edit_description, $this->original['description']],
            'specialization' => [$this->selectedSpecializations, $this->original['specialization']],
            'subjects'       => [$this->selectedSubjects, $this->original['subjects']],
        ])
            ->filter(fn($pair) => $pair[0] !== $pair[1])
            ->map(fn($pair) => $pair[0])
            ->toArray();

        if (empty($changes)) {
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes has been made.');
            $this->closeModal();
            return;
        }

        $curriculum = Curriculum::find($this->curriculum_id);
        $curriculum->update([
            'name' => $this->edit_name,
            'grade_level_id' => $this->edit_grade_level,
            'description' => $this->edit_description,
        ]);

        $curriculum->specializations()->sync($this->selectedSpecializations);

        $curriculum->curriculumSubjects()->delete();
        $subjectIds = Subject::whereIn('name', $this->selectedSubjects)->pluck('id');
        foreach ($subjectIds as $subjectId) {
            CurriculumSubject::create([
                'curriculum_id' => $curriculum->id,
                'subject_id' => $subjectId,
            ]);
        }

        $this->dispatch('swal-toast', icon: 'success', title: 'Curriculum has been updated successfully.');
        return $this->closeModal();
    }

    public function render()
    {
        $this->subjects = Subject::orderBy('name')->get();
        $this->specializations = Auth::user()->accountable->specializations;
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        return view('livewire.curriculum-edit-modal');
    }
}
