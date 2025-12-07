<?php

namespace App\Livewire;

use App\Models\Feed;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\CurriculumLegend;
use App\Models\CurriculumSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CurriculumAddModal extends Component
{
    public $isOpen = false;
    public $showSpecializationDropdown = false;
    public $showSubjectDropdown = false;
    public $specializations;

    public $add_name, $add_grade_level = '', $add_specialization, $add_description, $add_subject, $subjects, $grade_levels;

    public $selectedSpecializations = [], $selectedSubjects = [];
    public $legendPercentages = [];

    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatch('refresh')->to('curriculum-main');
        $this->dispatch('refresh')->to('curriculum-aside');
        $this->isOpen = false;
    }

    public function openSpecializationModal()
    {
        $this->showSpecializationDropdown = !$this->showSpecializationDropdown;
    }

    public function clearSpecializations()
    {
        $this->selectedSpecializations = [];
    }

    public function openSubjectModal()
    {
        $this->showSubjectDropdown = !$this->showSubjectDropdown;
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

    public function addCurriculum()
    {
        try {
            $this->validate([
                'add_name' => 'required|min:5|max:30',
                'add_grade_level' => 'required',
                'add_description' => 'nullable|max:255',
                'selectedSpecializations' => 'required|min:1',
                'selectedSubjects' => 'required|min:1',
            ], [
                'add_name.required' => 'Name is required.',
                'add_name.min' => 'Name must be at least 5 characters.',
                'add_name.max' => 'Name must not be more than 30 characters.',
                'add_grade_level.required' => 'Grade level is required.',
                'selectedSpecializations.required' => 'At least one specialization is required.',
                'selectedSubjects.required' => 'At least one subject is required.',
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
            return $this->dispatch('swal-toast', icon: 'error', title: $message);
        }

        $curriculum = Curriculum::create([
            'instructor_id' => Auth::user()->accountable->id,
            'name' => $this->add_name,
            'grade_level_id' => $this->add_grade_level,
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

        foreach ($this->legendPercentages as $key => $value) {
            CurriculumLegend::create([
                'curriculum_id' => $curriculum->id,
                'legend_key' => $key,
                'legend_label' => $this->legends[$key],
                'percentage' => $value,
            ]);
        }

        Feed::create([
            'notifiable_id' => Auth::user()->accountable->id,
            'notifiable_type' => get_class(Auth::user()->accountable),
            'group' => 'curriculum',
            'title' => 'New Curriculum Created',
            'message' => "A new curriculum named '{$this->add_name}' has been created.",
        ]);

        $this->dispatch('swal-toast', icon: 'success', title: 'Curriculum has been created successfully.');
        return $this->closeModal();
    }

    public function render()
    {
        $this->subjects = Subject::orderBy('name')->get();
        $this->specializations = Auth::user()->accountable->specializations;
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        return view('livewire.curriculum-add-modal');
    }
}
