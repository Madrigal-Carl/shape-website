<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ActivityAddModal extends Component
{
    public $grade_levels, $students, $curriculums, $selected_student = '';
    public $isOpen = true, $activeStudentId = null, $attempts = [];
    public $activity_name, $curriculum = '', $grade_level = '', $description;
    public $selected_students = [];
    public $student_search = '';

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

    public function resetFields()
    {
        $this->activity_name = null;
        $this->grade_level = '';
        $this->selected_student = '';
        $this->selected_students = [];
        $this->students = collect();
        $this->curriculums = collect();
        $this->curriculum = '';
        $this->activeStudentId = null;
        $this->attempts = [];
        $this->description = null;
    }

    public function validateActivity()
    {
        try {
            $this->validate([
                'activity_name'        => 'required|min:5|max:100',
                'grade_level'        => 'required',
                'curriculum'         => 'required',
            ], [
                'lesson_name.required' => 'Lesson name is required.',
                'lesson_name.min'      => 'Lesson name must be at least 5 characters.',
                'lesson_name.max'      => 'Lesson name must not exceed 100 characters.',
                'grade_level.required' => 'Grade & Section is required.',
                'curriculum.required'  => 'Please select a curriculum.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
            return false;
        }

        return true;
    }

    public function addActivity()
    {
        if (!$this->validateActivity()) {
            return;
        }

        $this->dispatch('swal-toast', icon: 'success', title: 'Lesson added successfully!');
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
    }

    public function updatedGradeLevel()
    {
        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)->where('grade_level', $this->grade_level)->where('status', 'active')->get();
        if (!empty($this->selected_students)) {
            $this->selected_students = [];
        }
        $this->curriculum = '';
        $this->selected_student = '';
        $this->students = collect();
    }

    public function updatedCurriculum()
    {
        if (!empty($this->selected_students)) {
            $this->selected_students = [];
        }
        $this->selected_student = '';
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

        return view('livewire.activity-add-modal', [
            'studentsToRender' => $studentsToRender,
        ]);
    }
}
