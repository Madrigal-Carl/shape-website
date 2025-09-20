<?php

namespace App\Livewire;

use App\Models\Lesson;
use Livewire\Component;
use App\Models\SchoolYear;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class LessonMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $school_year, $school_years, $quarter;
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

        $this->quarter = now()->schoolYear()->currentQuarter();
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
        $schoolYear = SchoolYear::find($this->school_year);

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
            ->when($this->quarter, function ($q) use ($schoolYear) {
                switch ($this->quarter) {
                    case 1:
                        $q->whereBetween('created_at', [$schoolYear->first_quarter_start, $schoolYear->first_quarter_end]);
                        break;
                    case 2:
                        $q->whereBetween('created_at', [$schoolYear->second_quarter_start, $schoolYear->second_quarter_end]);
                        break;
                    case 3:
                        $q->whereBetween('created_at', [$schoolYear->third_quarter_start, $schoolYear->third_quarter_end]);
                        break;
                    case 4:
                        $q->whereBetween('created_at', [$schoolYear->fourth_quarter_start, $schoolYear->fourth_quarter_end]);
                        break;
                }
            })
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.lesson-main', compact('lessons'));
    }
}
