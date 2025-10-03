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

    public function exportDocx()
    {
        return ReportHelper::generateLearningProgressReport();
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
