<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Student;
use Livewire\Component;
use App\Models\SchoolYear;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class StudentAdvanceModal extends Component
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

    public function advanceStudents()
    {
        if (!$this->canAdvanceStudent()) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'School year is not yet finished.');
        }

        $qualified = 0;
        $unqualified = 0;
        $graduated = 0;

        foreach ($this->selectedStudents as $studentId) {
            $student = Student::find($studentId);

            // Get latest enrollment history
            $latestEnrollment = $student->enrollments()->latest('id')->first();
            if (!$latestEnrollment) {
                $unqualified++;
                continue;
            }

            $currentLevelId = $latestEnrollment->grade_level_id;
            $gradeLevelIds = $this->grade_levels->pluck('id')->toArray();
            $currentIndex = array_search($currentLevelId, $gradeLevelIds);

            if ($currentIndex !== false) {
                // If student is at the last level -> graduate
                if ($currentIndex === count($gradeLevelIds) - 1) {
                    $latestEnrollment->update(['status' => 'graduated']);
                    $graduated++;
                }
                // Otherwise -> qualify for next level
                elseif ($currentIndex < count($gradeLevelIds) - 1) {
                    $latestEnrollment->update(['status' => 'qualified']);
                    $qualified++;
                }
            } else {
                $unqualified++;
            }
        }

        $this->closeModal();

        // Build message
        if ($qualified || $graduated) {
            $message = "{$qualified} student(s) qualified";
            $message .= $graduated ? ", {$graduated} graduated" : "";
            $message .= $unqualified ? ". {$unqualified} could not be advanced." : " successfully.";
        } elseif ($unqualified) {
            $message = "No students were advanced. {$unqualified} student(s) could not be advanced.";
        } else {
            $message = "No students selected.";
        }

        $this->dispatch('swal-toast', icon: ($qualified || $graduated) ? 'success' : 'info', title: $message);
    }


    public function canAdvanceStudent()
    {
        $latestSY = SchoolYear::latest('first_quarter_start')->first();

        if (!$latestSY) {
            return false;
        }

        return $latestSY->hasEnded();
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('student-main');
        $this->reset();
    }

    public function clearStudents()
    {
        $this->selectedStudents = [];
    }

    public function getFilteredStudentsProperty()
    {
        $excludedStatuses = ['graduated', 'qualified', 'transferred', 'dropped'];
        $query = Auth::user()->accountable->students()
            ->whereHas('enrollments', function ($q) use ($excludedStatuses) {
                $q->where('school_year_id', now()->schoolYear()->id)
                    ->whereNotIn('status', $excludedStatuses);
            });

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

    public function render()
    {
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        return view('livewire.student-advance-modal', [
            'students' => $this->filteredStudents,
        ]);
    }
}
