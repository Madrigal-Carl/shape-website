<?php

namespace App\Livewire;

use App\Models\Award;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Services\AwardPrinterHelper;
use Illuminate\Support\Facades\Auth;

class AwardMain extends Component
{
    public $awards;
    public $school_year, $school_years, $grade_level = '', $grade_levels;

    public function mount()
    {
        $this->school_year = now()->schoolYear()->id;
        $this->school_years = SchoolYear::orderBy('name')->get();
    }

    public function printAward($awardName, $awardeeCount)
    {
        $awardImages = [
            'Activity Ace' => 'award-icons-printables/activity-ace-printable.png',
            'Lesson Finisher' => 'award-icons-printables/lesson-finisher-printable.png',
            'Subject Specialist' => 'award-icons-printables/subject-specialist-printable.png',
            'Game Master' => 'award-icons-printables/game-master-printable.png',
            'Early Bird' => 'award-icons-printables/early-bird-printable.png',
            'Consistency Award' => 'award-icons-printables/consistency-printable.png',
        ];

        $imagePath = $awardImages[$awardName] ?? null;

        if (!$imagePath) {
            throw new \Exception("No image found for award: $awardName");
        }

        $awardees = Award::where('name', $awardName)
            ->first()
            ->students()
            ->where('student_awards.school_year_id', $this->school_year)
            ->whereHas('enrollments', function ($q) {
                $q->where('instructor_id', Auth::user()->accountable->id)
                    ->where('school_year_id', $this->school_year)
                    ->when($this->grade_level && $this->grade_level !== 'all', function ($q) {
                        $q->where('grade_level_id', $this->grade_level);
                    });
            })
            ->get()
            ->map(fn($student) => $student->full_name)
            ->toArray();

        $helper = new AwardPrinterHelper();

        return $helper->generate($awardName, $awardees, $imagePath);
    }

    public function openViewAwardModal($id)
    {
        $this->dispatch('openModal', id: $id, school_year: $this->school_year, grade_level: $this->grade_level)->to('award-view-modal');
    }

    public function render()
    {
        $this->awards = Award::withCount([
            'students as awardees_count' => function ($query) {
                $query->where('student_awards.school_year_id', $this->school_year)
                    ->whereHas('enrollments', function ($enrollmentQuery) {
                        $enrollmentQuery->where('instructor_id', Auth::user()->accountable->id)
                            ->where('school_year_id', $this->school_year)
                            ->when($this->grade_level && $this->grade_level !== 'all', function ($q) {
                                $q->where('grade_level_id', $this->grade_level);
                            });
                    });
            }
        ])->get();


        $this->grade_levels = Enrollment::whereIn('student_id', Auth::user()->accountable->students->pluck('id'))
            ->where('school_year_id', $this->school_year)
            ->with('gradeLevel')
            ->get()
            ->pluck('gradeLevel')
            ->unique('id')
            ->sortBy('name')
            ->values();
        return view('livewire.award-main');
    }
}
