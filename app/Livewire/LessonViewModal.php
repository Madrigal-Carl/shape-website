<?php

namespace App\Livewire;

use App\Models\Lesson;
use Livewire\Component;
use Livewire\Attributes\On;

class LessonViewModal extends Component
{
    public $isOpen = false;
    public $lesson_id = null;
    public $lesson;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->lesson_id = $id;
        $this->isOpen = true;

        $this->lesson = Lesson::with([
            'videos',
            'students',
            'lessonSubjectStudents.curriculum',
            'lessonSubjectStudents.subject',
            'activityLessons.activityLessonable' => function ($morphTo) {
                $morphTo->morphWith([
                    \App\Models\GameActivity::class => ['specializations'],
                    \App\Models\ClassActivity::class => ['curriculumSubject'],
                ]);
            }
        ])->find($id);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->lesson_id = null;
    }
    public function render()
    {
        return view('livewire.lesson-view-modal');
    }
}
