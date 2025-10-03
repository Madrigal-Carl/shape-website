<?php

namespace App\Livewire;

use App\Models\Todo;
use App\Models\Student;
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

class ActivityEditModal extends Component
{
    public $subjects, $grade_levels, $students, $curriculums;
    public $isOpen = false, $activeStudentId = null, $activity_id = null;
    public $activity_name, $curriculum = '', $subject = '', $grade_level = '', $description;

    public $search = '', $selectedTodoId = null, $selectedTodoLabel = null;
    public $expandedDomains = [], $expandedSubDomains = [], $checkedStudents = [];
    public $original = [];

    #[On('openModal')]
    public function openModal($id)
    {
        $this->activity_id = $id;
        $this->isOpen = true;

        $activity = ClassActivity::with([
            'students',
            'curriculumSubject.curriculum',
            'curriculumSubject.subject',
            'studentActivities'
        ])->findOrFail($id);

        // Assign basic info
        $this->activity_name = $activity->name;
        $this->description   = $activity->description;
        $this->grade_level   = $activity->curriculumSubject->curriculum->grade_level_id;
        $this->curriculum    = $activity->curriculumSubject->curriculum->id;
        $this->subject       = $activity->curriculumSubject->subject->id;

        $this->selectedTodoId    = $activity->todo_id;
        $this->selectedTodoLabel = $activity->todo?->todo;
        $this->checkedStudents = $activity->studentActivities
            ->where('status', 'finished')
            ->pluck('student_id')
            ->toArray();

        // Load students list
        $this->students = $activity->relatedStudents();

        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)
            ->where('grade_level_id', $this->grade_level)
            ->where('status', 'active')
            ->get();

        $this->subjects = Subject::whereHas('curriculumSubjects', function ($q) {
            $q->where('curriculum_id', $this->curriculum);
        })->get();

        $this->original = [
            'name'        => $this->activity_name,
            'description' => $this->description,
            'grade_level' => $this->grade_level,
            'curriculum'  => $this->curriculum,
            'subject'     => $this->subject,
            'students'    => $this->checkedStudents,
            'todo_id'     => $this->selectedTodoId,
        ];
    }


    public function closeModal()
    {
        $this->dispatch('refresh')->to('activity-main');
        $this->isOpen = false;
        $this->activeStudentId = null;
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

    public function editActivity()
    {
        if (!$this->validateActivity()) {
            return;
        }

        $current = [
            'name'        => $this->activity_name,
            'description' => $this->description,
            'grade_level' => $this->grade_level,
            'curriculum'  => $this->curriculum,
            'subject'     => $this->subject,
            'students'    => $this->checkedStudents,
            'todo_id'     => $this->selectedTodoId,
        ];

        if ($current == $this->original) {
            $this->closeModal();
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes have been made.');
            return;
        }

        $schoolYear = now()->schoolYear();
        if (!$schoolYear || $schoolYear->hasEnded()) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'You cannot add an activity. The current school year has already ended.');
        }

        $activity = ClassActivity::findOrFail($this->activity_id);

        $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum)
            ->where('subject_id', $this->subject)
            ->first();

        $activity->update([
            'curriculum_subject_id' => $curriculumSubject->id,
            'todo_id'               => $this->selectedTodoId,
            'name'                  => $this->activity_name,
            'description'           => $this->description,
        ]);

        $activity->studentActivities()->delete();
        foreach ($this->students as $student) {
            StudentActivity::create([
                'student_id'        => $student->id,
                'activity_lesson_id' => $activity->id,
                'activity_lesson_type' => ClassActivity::class,
                'status'            => in_array($student->id, $this->checkedStudents ?? [])
                    ? 'finished'
                    : 'unfinished',
            ]);
        }

        $this->dispatch('swal-toast', icon: 'success', title: 'Activity updated successfully!');
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
        $this->selectedTodoId = null;
        $this->selectedTodoLabel = null;
        $this->subjects = collect();
        $this->students = collect();
    }

    public function updatedCurriculum()
    {
        $this->subject = '';
        $this->selectedTodoId = null;
        $this->selectedTodoLabel = null;
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
        return view('livewire.activity-edit-modal');
    }
}
