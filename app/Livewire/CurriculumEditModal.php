<?php

namespace App\Livewire;

use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\CurriculumSubject;

class CurriculumEditModal extends Component
{
    public $isOpen = false;
    public $subjects;
    public $curriculum_id = null;
    public $edit_name;
    public $edit_grade_level;
    public $edit_specialization;
    public $selectedSpecializations = [];
    public $edit_description;
    public $edit_subject;
    public $selectedSubjects = [];
    public $original = [];

    public function mount()
    {
        $this->subjects = Subject::orderBy('name')->get();
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->curriculum_id = $id;
        $this->isOpen = true;

        $curriculum = Curriculum::with('curriculumSubjects.subject')->find($this->curriculum_id);

        $this->edit_name = $curriculum->name;
        $this->edit_grade_level = $curriculum->grade_level;
        $this->edit_description = $curriculum->description;
        $this->selectedSpecializations = $curriculum->specialization;

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
        $this->isOpen = false;
    }

    public function updatedEditSpecialization($value)
    {
        if ($value && !in_array($value, $this->selectedSpecializations)) {
            $this->selectedSpecializations[] = $value;
        }

        $this->edit_specialization = '';
    }

    public function removeSpecialization($index)
    {
        unset($this->selectedSpecializations[$index]);
        $this->selectedSpecializations = array_values($this->selectedSpecializations);
    }

    public function updatedEditSubject($value)
    {
        if ($value && !in_array($value, $this->selectedSubjects)) {
            $this->selectedSubjects[] = $value;
        }

        $this->edit_subject = '';
    }

    public function removeSubject($index)
    {
        unset($this->selectedSubjects[$index]);
        $this->selectedSubjects = array_values($this->selectedSubjects);
    }

    public function editCurriculum()
    {
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
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes detected.');
            return;
        }

        $curriculum = Curriculum::find($this->curriculum_id);
        $curriculum->update([
            'name' => $this->edit_name,
            'grade_level' => $this->edit_grade_level,
            'specialization' => $this->selectedSpecializations,
            'description' => $this->edit_description,
        ]);

        CurriculumSubject::where('curriculum_id', $this->curriculum_id)->delete();

        $subjects = Subject::whereIn('name', $this->selectedSubjects)->pluck('id');
        foreach ($subjects as $subject) {
            CurriculumSubject::create([
                'curriculum_id' => $curriculum->id,
                'subject_id' => $subject,
            ]);
        }

        $this->dispatch('swal-toast', icon : 'success', title : 'Curriculum has been updated successfully.');
        return $this->closeModal();
    }

    public function render()
    {
        return view('livewire.curriculum-edit-modal');
    }
}
