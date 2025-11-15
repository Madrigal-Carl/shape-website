<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Feed;
use App\Models\Student;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

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
        $last = SchoolYear::orderBy('fourth_quarter_end', 'desc')->first();
        if ($last->hasEnded()) {
            $schoolYear = $last;
        } else {
            $schoolYear = SchoolYear::orderBy('fourth_quarter_end', 'desc')->skip(1)->first();
        }

        $instructor = Auth::user()->accountable;

        // Grade rank map
        $gradeRank = [
            'kindergarten 1' => 1,
            'kindergarten 2' => 2,
            'kindergarten 3' => 3,
            'grade 1'        => 4,
        ];

        // Instructor's assigned grade levels
        $allowedGradeLevels = $instructor->gradeLevels()->pluck('name')->map(fn($n) => strtolower(trim($n)))->values();
        $allowedRanks = collect($allowedGradeLevels)->map(fn($g) => $gradeRank[$g] ?? null)->filter();

        // Compute previous grade levels (one rank lower)
        $previousRanks = $allowedRanks->map(fn($r) => $r - 1)->filter(fn($r) => $r > 0);
        $previousGradeLevels = collect($gradeRank)
            ->filter(fn($rank) => $previousRanks->contains($rank))
            ->keys()
            ->map(fn($n) => strtolower(trim($n)));

        $previousGradeLevelIds = GradeLevel::whereIn('name', $previousGradeLevels)->pluck('id');

        $query = Student::query()
            ->whereHas('enrollments', function ($q) use ($schoolYear) {
                $q->where('school_year_id', $schoolYear->id)
                    ->where('status', 'qualified');
            })
            ->whereIn(
                'disability_type',
                $instructor->specializations
                    ->pluck('name')
                    ->map(fn($s) => strtolower(trim($s)))
            );

        if ($this->grade_level && $this->grade_level !== 'all') {
            // find the one rank below that grade only
            $selectedGrade = strtolower(GradeLevel::find($this->grade_level)->name);
            $selectedRank = $gradeRank[$selectedGrade] ?? null;

            if ($selectedRank) {
                $targetRank = $selectedRank - 1;
                $targetGradeLevels = collect($gradeRank)
                    ->filter(fn($rank) => $rank === $targetRank)
                    ->keys()
                    ->map(fn($n) => strtolower(trim($n)));

                $targetGradeLevelIds = GradeLevel::whereIn('name', $targetGradeLevels)->pluck('id');

                $query->whereHas('enrollments', function ($q) use ($schoolYear, $targetGradeLevelIds) {
                    $q->whereIn('grade_level_id', $targetGradeLevelIds)
                        ->where('school_year_id', $schoolYear->id);
                });
            }
        } else {
            // When "All" is selected, show all one rank lower than instructor’s grade levels
            $query->whereHas('enrollments', function ($q) use ($schoolYear, $previousGradeLevelIds) {
                $q->whereIn('grade_level_id', $previousGradeLevelIds)
                    ->where('school_year_id', $schoolYear->id);
            });
        }

        // Search filter
        if ($this->student_search) {
            $search = $this->student_search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%");
            });
        }

        $query->orderBy('first_name');

        return $query->with(['enrollments' => function ($q) use ($schoolYear) {
            $q->where('school_year_id', $schoolYear->id);
        }])->get();
    }


    public function addOldStudents()
    {
        $registered = 0;
        $skipped = 0;

        if (!$this->canRegisterStudent()) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'Enrollment period is closed.');
        }

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

                Feed::create([
                    'group' => 'student',
                    'title' => 'New Student Enrolled',
                    'message' => "'{$student->fullname}' has been enrolled as a student.",
                ]);

                // Create new enrollment
                $enrollment = Enrollment::create([
                    'instructor_id'  => Auth::user()->accountable->id,
                    'student_id'     => $student->id,
                    'grade_level_id' => $nextLevelId,
                    'school_year_id' => now()->schoolYear()->id,
                ]);

                // ✅ Create related education record
                $enrollment->educationRecord()->create([
                    'grade_level_id' => $currentLevelId,
                    'school_id'      => 109870,
                    'school_year'    => $latestEnrollment->schoolYear->name,
                    'school_name'    => 'Don Luis Hidalgo Memorial School',
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

    public function canRegisterStudent()
    {
        $today = Carbon::today();

        $latestSY = SchoolYear::latest('first_quarter_start')->first();

        if (!$latestSY) {
            return false;
        }

        $syStart  = Carbon::parse($latestSY->first_quarter_start);
        $syEnd    = Carbon::parse($latestSY->fourth_quarter_end);
        $firstQEnd = Carbon::parse($latestSY->first_quarter_end);

        if ($today->greaterThan($syEnd)) {
            return true;
        }

        if ($today->between($syStart, $firstQEnd)) {
            return true;
        }

        return false;
    }

    public function render()
    {
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        return view('livewire.student-add-old-modal', [
            'students' => $this->filteredStudents,
        ]);
    }
}
