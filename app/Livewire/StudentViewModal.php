<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use App\Models\SchoolYear;
use Livewire\Attributes\On;
use App\Services\ReportHelper;

class StudentViewModal extends Component
{
    public $isOpen = false;
    public $student_id = null;
    public $school_year = null;
    public $student, $quarter;

    #[On('openModal')]
    public function openModal($id, $school_year)
    {
        $this->student_id = $id;
        $this->school_year = $school_year;
        $this->quarter = now()->schoolYear()->currentQuarter();
        $this->isOpen = true;

        $this->student = Student::with([
            'guardian',
            'permanentAddress',
            'currentAddress',
            'lessons.schoolYear',
            'lessons.videos',
            'lessons.gameActivityLessons',
            'lessons.classActivities',
        ])->find($id);
    }

    function ordinal($number)
    {
        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        }
        return $number . $ends[$number % 10];
    }

    public function exportDocx()
    {
        $schoolYear = SchoolYear::find($this->school_year);
        $todayQuarter = $schoolYear->currentQuarter(); // current quarter based on today
        $requestedQuarter = $this->quarter; // quarter user is requesting

        // Determine the maximum allowed quarter to generate
        if ($schoolYear->hasEnded()) {
            // School year finished → allow all 4 quarters
            $maxQuarterAllowed = 4;
        } else {
            // School year ongoing → only previous quarters can be generated
            $maxQuarterAllowed = $todayQuarter - 1;
        }

        // If today is Q1 and school year not ended → disallow
        // if (!$schoolYear->hasEnded() && $maxQuarterAllowed <= 0) {
        //     $this->dispatch('swal-toast', icon: 'error', title: 'The 1st grading is not yet finished.');
        //     return;
        // }

        // If requested quarter is greater than allowed → disallow
        // if ($requestedQuarter > $maxQuarterAllowed) {
        //     $this->dispatch(
        //         'swal-toast',
        //         icon: 'error',
        //         title: "The {$this->ordinal($requestedQuarter)} quarter is not yet finished."
        //     );
        //     return;
        // }

        if ($schoolYear->hasEnded()) {
            $quarterToGenerate = 4;
        } else {
            $quarterToGenerate = min($requestedQuarter, $maxQuarterAllowed);
        }

        // Instantiate the report helper
        $helper = new ReportHelper();

        // Generate report based on disability type
        if ($this->student->disability_type === 'autism spectrum disorder') {
            return $helper->generateAutismReportCard($this->student_id, $this->school_year, $quarterToGenerate);
        } else {
            return $helper->generateSpeechHearingReportCard($this->student_id, $this->school_year, $quarterToGenerate);
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->student_id = null;
        $this->school_year = null;
    }

    public function render()
    {
        $filteredLessons = collect();

        if ($this->student) {
            $schoolYearModel = SchoolYear::find($this->school_year);

            $filteredLessons = $this->student->lessons
                ->filter(function ($lesson) use ($schoolYearModel) {
                    if ($lesson->school_year_id != $this->school_year) {
                        return false;
                    }
                    if (!$lesson->isInQuarter($schoolYearModel, (int) $this->quarter)) {
                        return false;
                    }
                    $hasActiveCurriculum = $lesson->lessonSubjectStudents
                        ->where('student_id', $this->student->id)
                        ->filter(fn($lss) => $lss->curriculum?->status === 'active')
                        ->isNotEmpty();

                    return $hasActiveCurriculum;
                });
        }

        return view('livewire.student-view-modal', compact('filteredLessons'));
    }
}
