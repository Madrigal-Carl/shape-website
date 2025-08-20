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
    public $quiz_questions = [];


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
