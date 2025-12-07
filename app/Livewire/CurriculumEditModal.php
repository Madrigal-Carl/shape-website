<?php

namespace App\Livewire;

use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\CurriculumLegend;
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
    public $legendPercentages = [];


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

        $this->legendPercentages = CurriculumLegend::where('curriculum_id', $this->curriculum_id)
            ->pluck('percentage', 'legend_key')
            ->toArray();

        $this->original = [
            'name'           => $this->edit_name,
            'grade_level'    => $this->edit_grade_level,
            'description'    => $this->edit_description,
            'specialization' => $this->selectedSpecializations,
            'subjects'       => $this->selectedSubjects,
            'legends'        => $this->legendPercentages,
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

    public function getLegendsProperty()
    {
        // If no specialization selected yet, return empty
        if (empty($this->selectedSpecializations)) return [];

        $selectedNames = $this->specializations
            ->whereIn('id', $this->selectedSpecializations)
            ->pluck('name')
            ->map(fn($n) => strtolower($n))
            ->toArray();

        if (in_array('autism spectrum disorder', $selectedNames)) {
            return [
                'P' => 'proficient',
                'AP' => 'approaching proficiency',
                'D' => 'developing',
                'B' => 'beginning',
                'NO/NA' => 'needs observe/not applicable',
            ];
        }

        if (in_array('speech disorder', $selectedNames) || in_array('hearing impaired', $selectedNames)) {
            return [
                'M' => 'mastered',
                'S' => 'satisfactory',
                'FS' => 'fair satisfactory',
                'AIN' => 'additional instruction needed',
                'NYI' => 'not yet introduced',
            ];
        }

        return [];
    }

    protected function validateLegendPercentages()
    {
        $legends = $this->legends;
        $values = array_map(fn($key) => $this->legendPercentages[$key] ?? null, array_keys($legends));

        // Check if any value is missing or not numeric
        foreach ($values as $value) {
            if (!is_numeric($value)) {
                throw ValidationException::withMessages([
                    'legendPercentages' => 'All legend percentages must be numeric values.',
                ]);
            }
        }

        // Check range 0-100
        foreach ($values as $value) {
            if ($value < 0 || $value > 100) {
                throw ValidationException::withMessages([
                    'legendPercentages' => 'Legend percentages must be between 0 and 100.',
                ]);
            }
        }

        // Check decreasing order
        for ($i = 0; $i < count($values) - 1; $i++) {
            if ($values[$i] <= $values[$i + 1]) {
                throw ValidationException::withMessages([
                    'legendPercentages' => 'Legend percentages must be in decreasing order.',
                ]);
            }
        }
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
                'selectedSpecializations.min' => 'You must select at least one specialization.',
                'selectedSubjects.min' => 'You must select at least one subject.',
            ]);

            $selectedNames = $this->specializations
                ->whereIn('id', $this->selectedSpecializations)
                ->pluck('name')
                ->map(fn($n) => strtolower($n))
                ->toArray();

            $hasAutism = in_array('autism spectrum disorder', $selectedNames);
            $hasSpeechOrHearing = in_array('speech disorder', $selectedNames) || in_array('hearing impaired', $selectedNames);

            if ($hasAutism && $hasSpeechOrHearing) {
                throw ValidationException::withMessages([
                    'selectedSpecializations' => 'Autism cannot be selected together with Speech or Hearing specializations.',
                ]);
            }

            $this->validateLegendPercentages();
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
            'legends'        => [$this->legendPercentages, $this->original['legends']],
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

        $currentSubjectIds = $curriculum->curriculumSubjects()
            ->pluck('subject_id')->toArray();
        $newSubjectIds = Subject::whereIn('name', $this->selectedSubjects)
            ->pluck('id')->toArray();
        $allSubjects = CurriculumSubject::withTrashed()
            ->where('curriculum_id', $curriculum->id)
            ->get();
        $softDeletedSubjects = $allSubjects
            ->whereNotNull('deleted_at')
            ->pluck('subject_id')
            ->toArray();
        $toAdd = array_diff($newSubjectIds, $allSubjects->pluck('subject_id')->toArray());
        $toRemove = array_diff($currentSubjectIds, $newSubjectIds);
        $toRestore = array_intersect($newSubjectIds, $softDeletedSubjects);
        foreach ($toAdd as $subjectId) {
            CurriculumSubject::create([
                'curriculum_id' => $curriculum->id,
                'subject_id' => $subjectId,
            ]);
        }
        foreach ($toRemove as $subjectId) {
            $cs = CurriculumSubject::where('curriculum_id', $curriculum->id)
                ->where('subject_id', $subjectId)
                ->first();
            if ($cs) {
                $cs->delete();
                $cs->lessonSubjectStudents()->delete();
            }
        }
        foreach ($toRestore as $subjectId) {
            $cs = CurriculumSubject::withTrashed()
                ->where('curriculum_id', $curriculum->id)
                ->where('subject_id', $subjectId)
                ->first();
            if ($cs) {
                $cs->restore();
                $cs->lessonSubjectStudents()->withTrashed()->restore();
            }
        }

        foreach ($this->legendPercentages as $key => $value) {
            CurriculumLegend::updateOrCreate([
                'curriculum_id' => $curriculum->id,
                'legend_key' => $key,
            ], [
                'legend_label' => $this->legends[$key],
                'percentage' => $value,
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
