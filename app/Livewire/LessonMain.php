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
    public $school_year, $school_years;
    public $listeners = ['refresh' => '$refresh'];
    public function mount()
    {
        $this->school_year = now()->schoolYear()->id;

        $this->school_years = Auth::user()->accountable
            ->lessons()
            ->with('schoolYear')
            ->get()
            ->pluck('schoolYear')
            ->unique('id')
            ->sortBy('name')
            ->values();
    }

    public function openAddLessonModal()
    {
        $this->dispatch('openModal')->to('lesson-add-modal');
    }

    public function openEditLessonModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('lesson-edit-modal');
    }

    public function openViewLessonModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('lesson-view-modal');
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
                'activityLessons',
            ])
            ->where('school_year_id', $this->school_year)
            ->whereHas('lessonSubjectStudents.curriculumSubject.curriculum', function ($q) {
                $q->where('instructor_id', Auth::user()->accountable->id)->where('status', 'active');
            })
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.lesson-main', compact('lessons'));
    }
}
