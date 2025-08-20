<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Activity;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class LessonAddModal extends Component
{
    public $subjects;
    public $grade_levels;
    public $students;
    public $activities;
    public $isOpen = true;
    public $lesson_name;
    public $subject;
    public $grade_level;
    public $selected_student;
    public $description;
    public $activity;
    public $selected_activities = [];
    public $quiz_name;
    public $quiz_description;
    public $questions = [
        [
            'question' => '',
            'options' => [
                ['text' => '', 'is_correct' => false],
                ['text' => '', 'is_correct' => false],
            ],
        ],
    ];


    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        // $this->resetVariables();
        $this->dispatch('refresh')->to('lesson-main');
        $this->isOpen = false;
    }

    public function addLesson()
    {

    }

    public function updatedActivity($value)
    {
        $activity = Activity::find($value);

        if ($activity && !collect($this->selected_activities)->pluck('id')->contains($activity->id)) {
            $this->selected_activities[] = $activity;
        }
    }

    public function removeActivity($index)
    {
        unset($this->selected_activities[$index]);
        $this->selected_activities = array_values($this->selected_activities);
    }

    public function addQuestion()
    {
        if (!empty($this->questions)) {
            $lastQuestion = end($this->questions);

            $hasQuestionText = trim($lastQuestion['question']) !== '';

            $filledOptions = collect($lastQuestion['options'])
                ->filter(fn($opt) => trim($opt['text']) !== '')
                ->count();

            $hasCorrectAnswer = collect($lastQuestion['options'])
                ->contains(fn($opt) => $opt['is_correct'] === true);

            if (!$hasQuestionText) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Fill in the question field first.');
            }

            if ($filledOptions < 2) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Add at least 2 options.');
            }

            if (!$hasCorrectAnswer) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Please select a correct answer.');
            }
        }

        $this->questions[] = [
            'question' => '',
            'options' => [
                ['text' => '', 'is_correct' => false],
                ['text' => '', 'is_correct' => false],
            ],
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function addOption($qIndex)
    {
        $this->questions[$qIndex]['options'][] = ['text' => '', 'is_correct' => false];
    }

    public function removeOption($qIndex, $oIndex)
    {
        unset($this->questions[$qIndex]['options'][$oIndex]);
        $this->questions[$qIndex]['options'] = array_values($this->questions[$qIndex]['options']);
    }

    public function setCorrectAnswer($qIndex, $oIndex)
    {
        foreach ($this->questions[$qIndex]['options'] as $key => $option) {
            $this->questions[$qIndex]['options'][$key]['is_correct'] = ($key === $oIndex);
        }
    }
    public function mount()
    {
        $this->subjects = Subject::orderBy('name')->get();
        $this->grade_levels = Profile::orderBy('grade_level')->pluck('grade_level')->unique()->values()->toArray();
        $this->students = Auth::user()->accountable->students;
        $this->activities = Activity::orderBy('id')->get();
    }

    public function render()
    {
        return view('livewire.lesson-add-modal');
    }
}
