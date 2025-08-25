<?php

namespace App\Livewire;

use App\Models\Lesson;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class LessonMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $listeners = ['refresh' => '$refresh'];

    public function openAddLessonModal()
    {
        $this->dispatch('openModal')->to('lesson-add-modal');
    }

    public function openEditLessonModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('lesson-edit-modal');
    }

    public function render()
    {
        $lessons = Lesson::with([
            'lessonSubjectStudents.curriculumSubject.subject',
            'lessonSubjectStudents.curriculumSubject.curriculum',
        ])
        ->withCount([
            'lessonSubjectStudents',
            'videos',
            'quiz',
            'activityLessons',
        ])
        ->whereHas('lessonSubjectStudents.curriculumSubject.curriculum', function ($q) {
            $q->where('instructor_id', Auth::user()->accountable->id);
        })
        ->when($this->search, function ($q) {
            $q->where('title', 'like', '%' . $this->search . '%');
        })
        ->orderByDesc('created_at')
        ->paginate(10);

        return view('livewire.lesson-main', compact('lessons'));
    }
}
