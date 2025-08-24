<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class LessonMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $status = 'all';
    public $listeners = ['refresh' => '$refresh'];

    public function openAddLessonModal()
    {
        $this->dispatch('openModal')->to('lesson-add-modal');
    }

    public function render()
    {
        $lessons = Lesson::with([
            'lessonSubject.curriculumSubject.subject',
            'lessonSubject.curriculumSubject.curriculum',
            'lessonSubject.curriculumSubject.students',
        ])
        ->withCount([
            'videos',
            'activityLessons',
            'lessonQuizzes',
        ])
        ->whereHas('lessonSubject.curriculumSubject.curriculum', function ($q) {
            $q->where('instructor_id', Auth::user()->accountable->id);
        })
        ->orderByDesc('created_at')
        ->paginate(10)
        ->through(function ($lesson) {
            $lesson->students_count = $lesson->lessonSubject->curriculumSubject->students->count();
            return $lesson;
        });

        return view('livewire.lesson-main', compact('lessons'));
    }
}
