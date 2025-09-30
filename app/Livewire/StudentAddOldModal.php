<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Enrollment;

class StudentAddOldModal extends Component
{
    public $isOpen = false;
    public $grade_level = '', $grade_levels;
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
                $q->where('grade_level_id', $this->grade_level)
                    ->where('school_year_id', now()->schoolYear()->id);
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
            $q->where('school_year_id', now()->schoolYear()->id);
        }])->get();
    }

    public function addOldStudents()
    {
        $registered = 0;
        $skipped = 0;

        foreach ($this->selectedStudents as $studentId) {
            $student = Student::find($studentId);

            $currentEnrollment = $student->enrollments()
                ->where('school_year_id', now()->schoolYear()->id)
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

            $currentLevelId = $latestEnrollment->grade_level_id;
            $gradeLevelIds = $this->grade_levels->pluck('id')->toArray();
            $currentIndex = array_search($currentLevelId, $gradeLevelIds);

            if ($currentIndex !== false && $currentIndex < count($gradeLevelIds) - 1) {
                $nextLevelId = $gradeLevelIds[$currentIndex + 1];

                // Create enrollment for the next school year
                Enrollment::create([
                    'instructor_id' => Auth::user()->accountable->id,
                    'student_id' => $student->id,
                    'grade_level_id' => $nextLevelId,
                    'school_year_id' => now()->schoolYear()->id,
                ]);

                $registered++;
            } else {
                $skipped++;
            }
        }

        $this->closeModal();

        if ($registered && $skipped) {
            $message = "{$registered} student(s) registered successfully. {$skipped} student(s) could not be registered.";
        } elseif ($registered) {
            $message = "{$registered} student(s) registered successfully.";
        } elseif ($skipped) {
            $message = "No students were registered. {$skipped} student(s) could not be registered.";
        } else {
            $message = "No students selected.";
        }

        $this->dispatch('swal-toast', icon: $registered ? 'success' : 'info', title: $message);
    }

    public function render()
    {
        $this->grade_levels = Auth::user()->accountable->gradeLevels;
        return view('livewire.student-add-old-modal', [
            'students' => $this->filteredStudents,
        ]);
    }
}
