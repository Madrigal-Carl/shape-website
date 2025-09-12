<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Enrollment;

class StudentMoveUpModal extends Component
{
    public $isOpen = false;
    public $grade_level = '';
    public $student_search = '';
    public $selectedStudents = [];

    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('student-main');
        $this->dispatch('refresh')->to('student-aside');
        $this->reset(['isOpen', 'grade_level', 'student_search', 'selectedStudents']);
    }

    public function clearStudents()
    {
        $this->selectedStudents = [];
    }

    public function getFilteredStudentsProperty()
    {
        $query = Auth::user()->accountable->students();

        // Filter by grade level
        if ($this->grade_level && $this->grade_level !== 'all') {
            $query->whereHas('enrollments', function ($q) {
                $q->where('grade_level', $this->grade_level)
                    ->where('school_year', now()->schoolYear());
            });
        }

        // Search by name
        if ($this->student_search) {
            $search = $this->student_search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%");
            });
        }
        $query->orderBy('first_name');
        return $query->with(['enrollments' => function ($q) {
            $q->where('school_year', now()->schoolYear());
        }])->get();
    }

    public function getGradeLevelOptionsProperty()
    {
        return Enrollment::whereIn(
            'student_id',
            Auth::user()->accountable->students->pluck('id')
        )
            ->pluck('grade_level')
            ->unique()
            ->sort()
            ->values();
    }

    public function moveUp()
    {
        $movedUp = 0;
        $skipped = 0;

        foreach ($this->selectedStudents as $studentId) {
            $student = Student::find($studentId);

            $currentEnrollment = $student->enrollments()
                ->where('school_year', now()->schoolYear())
                ->first();

            if ($currentEnrollment) {
                $skipped++;
                continue;
            }

            $latestEnrollment = $student->enrollments()->latest('id')->first();
            if (!$latestEnrollment) {
                $skipped++;
                continue;
            }

            $currentLevel = strtolower($latestEnrollment->grade_level);
            $currentIndex = array_search($currentLevel, $this->gradeLevels);

            if ($currentIndex !== false && $currentIndex < count($this->gradeLevels) - 1) {
                $nextLevel = $this->gradeLevels[$currentIndex + 1];
                Enrollment::create([
                    'student_id' => $student->id,
                    'grade_level' => $nextLevel,
                    'school_year' => now()->schoolYear(),
                ]);
                $movedUp++;
            } else {
                $skipped++;
            }
        }

        $this->closeModal();

        if ($movedUp && $skipped) {
            $message = "{$movedUp} student(s) moved up successfully. {$skipped} student(s) could not be moved up.";
        } elseif ($movedUp) {
            $message = "{$movedUp} student(s) moved up successfully.";
        } elseif ($skipped) {
            $message = "No students were moved up. {$skipped} student(s) could not be moved up.";
        } else {
            $message = "No students selected.";
        }

        $this->dispatch('swal-toast', icon: $movedUp ? 'success' : 'info', title: $message);
    }

    public function render()
    {
        return view('livewire.student-move-up-modal', [
            'students' => $this->filteredStudents,
            'gradeLevelOptions' => $this->gradeLevelOptions,
        ]);
    }
}
