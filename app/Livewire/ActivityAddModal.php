<?php

namespace App\Livewire;

use App\Models\Todo;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\ClassActivity;
use App\Models\ActivityLesson;
use App\Models\StudentActivity;
use App\Models\CurriculumSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ActivityAddModal extends Component
{
    public $subjects, $grade_levels, $students, $curriculums;
    public $isOpen = false;
    public $activity_name, $curriculum = '', $subject = '', $grade_level = '', $description;

    public $search = '', $selectedTodoId = null, $selectedTodoLabel = null;
    public $expandedDomains = [], $expandedSubDomains = [], $checkedStudents = [];

    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('activity-main');
        $this->resetFields();
        $this->isOpen = false;
    }

    public function toggleDomain($domainId)
    {
        if (in_array($domainId, $this->expandedDomains)) {
            $this->expandedDomains = array_diff($this->expandedDomains, [$domainId]);
        } else {
            $this->expandedDomains[] = $domainId;
        }
    }

    public function toggleSubDomain($subDomainId)
    {
        if (in_array($subDomainId, $this->expandedSubDomains)) {
            $this->expandedSubDomains = array_diff($this->expandedSubDomains, [$subDomainId]);
        } else {
            $this->expandedSubDomains[] = $subDomainId;
        }
    }


    public function selectTodo($todoId)
    {
        $todo = Todo::find($todoId);
        $this->selectedTodoId = $todo->id;
        $this->selectedTodoLabel = $todo->todo;
    }

    public function getFilteredDomainProperty()
    {
        $subject = Subject::find($this->subject);

        if (!$subject) {
            return collect();
        }

        return $subject->domains()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
            })
            ->get();
    }

    public function resetFields()
    {
        $this->activity_name = null;
        $this->subject = '';
        $this->grade_level = '';
        $this->search = '';
        $this->subjects = collect();
        $this->students = collect();
        $this->curriculums = collect();
        $this->curriculum = '';
        $this->selectedTodoId = null;
        $this->selectedTodoLabel = null;
        $this->description = null;
        $this->expandedDomains = [];
        $this->expandedSubDomains = [];
        $this->checkedStudents = [];
    }

    public function validateActivity()
    {
        try {
            $this->validate([
                'activity_name'        => 'required|min:5|max:100',
                'grade_level'        => 'required',
                'subject'            => 'required',
                'curriculum'         => 'required',
                'selectedTodoId'         => 'required',
            ], [
                'lesson_name.required' => 'Lesson name is required.',
                'lesson_name.min'      => 'Lesson name must be at least 5 characters.',
                'lesson_name.max'      => 'Lesson name must not exceed 100 characters.',
                'grade_level.required' => 'Grade & Section is required.',
                'subject.required'     => 'Please select a subject.',
                'curriculum.required'  => 'Please select a curriculum.',
                'selectedTodoId.required'  => 'Please select a Todo.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
            return false;
        }

        if ($this->students->isEmpty()) {
            $this->dispatch('swal-toast', icon: 'error', title: 'Please assign at least one student to this activity.');
            return false;
        }

        if (empty($this->checkedStudents) || count($this->checkedStudents) === 0) {
            $this->dispatch('swal-toast', icon: 'error', title: 'At least one student must finish the activity.');
            return false;
        }

        return true;
    }

    public function addActivity()
    {
        if (!$this->validateActivity()) {
            return;
        }

        $schoolYear = now()->schoolYear();
        if (!$schoolYear || $schoolYear->hasEnded()) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'You cannot add an activity. The current school year has already ended.');
        }

        $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum)->where('subject_id', $this->subject)->first();

        $activity = ClassActivity::create([
            'instructor_id' => Auth::user()->accountable->id,
            'curriculum_subject_id' => $curriculumSubject->id,
            'todo_id'               => $this->selectedTodoId,
            'name'        => $this->activity_name,
            'description' => $this->description,
        ]);

        $activityLesson = ActivityLesson::create([
            'activity_lessonable_id'   => $activity->id,
            'activity_lessonable_type' => ClassActivity::class,
        ]);

        foreach ($this->students as $student) {
            StudentActivity::create([
                'student_id' => $student->id,
                'activity_lesson_id' => $activityLesson->id,
                'status'             => in_array($student->id, $this->checkedStudents ?? [])
                    ? 'finished'
                    : 'unfinished',
            ]);
        }

        $this->dispatch('swal-toast', icon: 'success', title: 'Activity added successfully!');
        return $this->closeModal();
    }

    public function mount()
    {
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        $this->students = collect();
        $this->curriculums = collect();
        $this->subjects = collect();
    }

    public function updatedGradeLevel()
    {
        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)->where('grade_level_id', $this->grade_level)->where('status', 'active')->get();
        $this->curriculum = '';
        $this->subject = '';
        $this->subjects = collect();
        $this->students = collect();
    }

    public function updatedCurriculum()
    {
        $this->subject = '';
        $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
            $query->where('curriculum_id', $this->curriculum);
        })->get();
        $this->students = Auth::user()->accountable->students()
            ->where('status', 'active')
            ->whereHas('enrollments', function ($query) {
                $query->where('grade_level_id', $this->grade_level)
                    ->where('school_year_id', now()->schoolYear()->id);
            })
            ->whereIn(
                'disability_type',
                Curriculum::find($this->curriculum)
                    ->specializations()
                    ->pluck('name')
            )
            ->get();

        $this->checkedStudents = [];
    }

    public function render()
    {
        return view('livewire.activity-add-modal');
    }
}
