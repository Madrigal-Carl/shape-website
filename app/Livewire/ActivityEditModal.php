<?php

namespace App\Livewire;

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
    public $subjects, $grade_levels, $students, $curriculums, $selected_student = '';
    public $isOpen = false, $activeStudentId = null, $activity_id = null, $attempts = [], $completed = [];
    public $activity_name, $curriculum = '', $subject = '', $grade_level = '', $description;
    public $selected_students = [];
    public $student_search = '';
    public $original = [];

    #[On('openModal')]
    public function openModal($id)
    {
        $this->activity_id = $id;
        $this->isOpen = true;

        $activity = ClassActivity::with([
            'students',
            'activityLesson',
            'curriculumSubject.curriculum',
            'curriculumSubject.subject',
            'studentActivities.logs'
        ])->findOrFail($id);

        // Assign basic info
        $this->activity_name = $activity->name;
        $this->description   = $activity->description;

        $this->grade_level   = $activity->curriculumSubject->curriculum->grade_level;
        $this->curriculum    = $activity->curriculumSubject->curriculum->id;
        $this->subject       = $activity->curriculumSubject->subject->id;

        // Preselect students assigned to this activity
        $this->selected_students = $activity->students->pluck('id')->toArray();

        // Load students list
        $this->students = Auth::user()->accountable->students()
            ->where('status', 'active')
            ->whereHas('enrollments', function ($query) {
                $query->where('grade_level', $this->grade_level)
                    ->where('school_year', now()->schoolYear());
            })
            ->whereIn(
                'disability_type',
                Curriculum::find($this->curriculum)
                    ->specializations()
                    ->pluck('name')
            )
            ->get();

        // Pre-fill attempts and completion per student
        foreach ($activity->studentActivities as $studentActivity) {
            $sid = $studentActivity->student_id;
            $this->completed[$sid] = $studentActivity->logs->contains(fn($log) => $log->status === 'completed');
            $this->attempts[$sid] = $studentActivity->logs->map(function ($log) {
                return [
                    'score' => $log->score,
                    'time'  => $log->time_spent_seconds / 60,
                ];
            })->toArray();

            if (empty($this->attempts[$sid])) {
                $this->attempts[$sid] = [['score' => '0', 'time' => '0']];
            }
        }

        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)
            ->where('grade_level', $this->grade_level)
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
            'students'    => $this->selected_students,
            'attempts'    => $this->attempts,
            'completed'   => $this->completed,
        ];
    }


    public function closeModal()
    {
        $this->dispatch('refresh')->to('activity-main');
        $this->isOpen = false;
        $this->activeStudentId = null;
    }

    public function getFilteredStudentsProperty()
    {
        return $this->students
            ->when($this->student_search, function ($q) {
                return $q->filter(function ($student) {
                    return str_contains(
                        strtolower($student->full_name),
                        strtolower($this->student_search)
                    );
                });
            });
    }

    public function toggleStudent($studentId)
    {
        if (in_array($studentId, $this->selected_students)) {
            $this->selected_students = array_values(
                array_diff($this->selected_students, [$studentId])
            );
        } else {
            $this->selected_students[] = $studentId;
        }
    }

    public function clearStudents()
    {
        $this->selected_students = [];
    }

    public function validateActivity()
    {
        try {
            $this->validate([
                'activity_name'        => 'required|min:5|max:100',
                'grade_level'        => 'required',
                'subject'            => 'required',
                'curriculum'         => 'required',
            ], [
                'lesson_name.required' => 'Lesson name is required.',
                'lesson_name.min'      => 'Lesson name must be at least 5 characters.',
                'lesson_name.max'      => 'Lesson name must not exceed 100 characters.',
                'grade_level.required' => 'Grade & Section is required.',
                'subject.required'     => 'Please select a subject.',
                'curriculum.required'  => 'Please select a curriculum.',
            ]);
            if ($this->students->isEmpty()) {
                $this->dispatch('swal-toast', icon: 'error', title: 'Please assign at least one student to this activity.');
                return false;
            }
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
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
            'students'    => $this->selected_students,
            'attempts'    => $this->attempts,
            'completed'   => $this->completed,
        ];

        if ($current == $this->original) {
            $this->closeModal();
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes have been made.');
            return;
        }

        $activity = ClassActivity::findOrFail($this->activity_id);
        $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum)
            ->where('subject_id', $this->subject)
            ->firstOrFail();

        $activity->update([
            'name'                  => $this->activity_name,
            'description'           => $this->description,
            'curriculum_subject_id' => $curriculumSubject->id,
        ]);

        $activityLesson = $activity->activityLesson()->firstOrFail();

        foreach ($activityLesson->studentActivities as $studentActivity) {
            $studentActivity->logs()->delete();
            $studentActivity->delete();
        }

        $studentsToAssign = empty($this->selected_students)
            ? $this->students
            : Student::whereIn('id', $this->selected_students)->get();

        foreach ($studentsToAssign as $student) {
            $studentActivity = StudentActivity::create([
                'student_id' => $student->id,
                'activity_lesson_id' => $activityLesson->id,
            ]);

            if (isset($this->attempts[$student->id])) {
                $attempts = $this->attempts[$student->id] ?? [];
                $lastIndex = count($attempts) - 1;

                foreach ($attempts as $index => $attempt) {
                    $studentActivity->logs()->create([
                        'score'          => $attempt['score'] ?? 0,
                        'time_spent_seconds'     => isset($attempt['time']) ? ($attempt['time'] * 60) : 0,
                        'attempt_number' => $index + 1,
                        'status'         => (
                            $this->completed[$student->id] ?? true
                        )
                            ? ($index === $lastIndex ? 'completed' : 'in-progress')
                            : 'in-progress',
                    ]);
                }
            }
        }

        $this->dispatch('swal-toast', icon: 'success', title: 'Activity updated successfully!');
        return $this->closeModal();
    }

    public function mount()
    {
        $this->grade_levels = Curriculum::where('instructor_id', Auth::user()->accountable->id)
            ->where('status', 'active')
            ->orderBy('grade_level')
            ->pluck('grade_level')
            ->unique()
            ->values()
            ->toArray();
        $this->students = collect();
        $this->curriculums = collect();
        $this->subjects = collect();
    }

    public function updatedGradeLevel()
    {
        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)->where('grade_level', $this->grade_level)->where('status', 'active')->get();
        if (!empty($this->selected_students)) {
            $this->selected_students = [];
        }
        $this->curriculum = '';
        $this->subject = '';
        $this->selected_student = '';
        $this->selected_students = [];
        $this->subjects = collect();
        $this->students = collect();
    }

    public function updatedCurriculum()
    {
        if (!empty($this->selected_students)) {
            $this->selected_students = [];
        }
        $this->subject = '';
        $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
            $query->where('curriculum_id', $this->curriculum);
        })->get();
        $this->selected_student = '';
        $this->selected_students = [];
        $this->students = Auth::user()->accountable->students()
            ->where('status', 'active')
            ->whereHas('enrollments', function ($query) {
                $query->where('grade_level', $this->grade_level)
                    ->where('school_year', now()->schoolYear());
            })
            ->whereIn(
                'disability_type',
                Curriculum::find($this->curriculum)
                    ->specializations()
                    ->pluck('name')
            )
            ->get();
    }

    public function toggleStudentAccordion($studentId)
    {
        if ($this->activeStudentId === $studentId) {
            $this->activeStudentId = null;
        } else {
            $this->activeStudentId = $studentId;

            if (!isset($this->attempts[$studentId])) {
                $this->attempts[$studentId] = [['score' => '0', 'time' => '0']];
            }

            if (!isset($this->completed[$studentId])) {
                $this->completed[$studentId] = true;
            }
        }
    }

    public function addAttempt($studentId)
    {
        if (!isset($this->attempts[$studentId])) {
            $this->attempts[$studentId] = [['score' => '0', 'time' => '0']];
            return;
        }

        $lastAttempt = end($this->attempts[$studentId]);

        // Only add if last attempt is filled
        if (!empty($lastAttempt['score']) && !empty($lastAttempt['time'])) {
            $this->attempts[$studentId][] = ['score' => '0', 'time' => '0'];
        } else {
            $this->dispatch(
                'swal-toast',
                icon: 'error',
                title: 'Please fill in the last attempt before adding another.'
            );
        }
    }

    public function removeAttempt($studentId)
    {
        if (isset($this->attempts[$studentId]) && count($this->attempts[$studentId]) > 1) {
            array_pop($this->attempts[$studentId]);
        }
    }

    public function render()
    {
        $studentsToRender = empty($this->selected_students)
            ? $this->students
            : $this->students->whereIn('id', $this->selected_students);
        return view('livewire.activity-edit-modal', [
            'studentsToRender' => $studentsToRender,
        ]);
    }
}
