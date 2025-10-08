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
        // $schoolYear = SchoolYear::find($this->school_year);
        // $todayQuarter = $schoolYear->currentQuarter();
        // $requestedQuarter = $this->quarter;
        // if ($requestedQuarter == 1) {
        //     $this->dispatch('swal-toast', icon: 'error', title: 'The 1st grading is not yet finished.');
        //     return;
        // }

        // if ($schoolYear->hasEnded()) {
        //     $quarterToGenerate = 4;
        // } else {
        //     if ($requestedQuarter > $todayQuarter) {
        //         $this->dispatch(
        //             'swal-toast',
        //             icon: 'error',
        //             title: "The {$this->ordinal($todayQuarter)} quarter is not yet finished."
        //         );
        //         return;
        //     }
        //     $quarterToGenerate = $todayQuarter - 1;
        // }

        $helper = new ReportHelper();

        if ($this->student->disability_type === 'autism spectrum disorder') {
            // return $helper->generateAutismReportCard($this->student_id, $this->school_year, $quarterToGenerate);
            return $helper->generateAutismReportCard($this->student_id, $this->school_year, 1);
        } else {
            // return $helper->generateSpeechHearingReportCard($this->student_id, $this->school_year, $quarterToGenerate);
            return $helper->generateSpeechHearingReportCard($this->student_id, $this->school_year, 1);
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
