<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use App\Models\SchoolYear;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\ReportHelper;
use Livewire\WithoutUrlPagination;

class StudentViewModal extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $isOpen = false;
    public $student_id = null;
    public $subject = '';
    public $school_year = null;
    public $student, $quarter;
    public $openLesson = null;

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
        $todayQuarter = $schoolYear->currentQuarter();
        $requestedQuarter = $this->quarter;
        if ($requestedQuarter == 1) {
            $this->dispatch('swal-toast', icon: 'error', title: 'The 1st grading is not yet finished.');
            return;
        }

        if ($schoolYear->hasEnded()) {
            $quarterToGenerate = 4;
        } else {
            if ($requestedQuarter > $todayQuarter) {
                $this->dispatch(
                    'swal-toast',
                    icon: 'error',
                    title: "The {$this->ordinal($todayQuarter)} quarter is not yet finished."
                );
                return;
            }
            $quarterToGenerate = $todayQuarter - 1;
        }

        $helper = new ReportHelper();

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
        // $this->subject = '';
    }

    public function getSubjectsProperty()
    {
        if (!$this->student) return collect();

        $subjects = $this->student->lessons
            ->flatMap(function ($lesson) {
                return $lesson->lessonSubjectStudents
                    ->map(fn($lss) => $lss->subject)
                    ->filter(); // remove null
            })
            ->unique('id') // only unique subjects
            ->values();

        return $subjects;
    }

    public function toggleLesson($lessonId)
    {
        $this->openLesson = $this->openLesson === $lessonId ? null : $lessonId;
    }

    public function render()
    {
        if (!$this->student) {
            return view('livewire.student-view-modal', [
                'filteredLessons' => collect()
            ]);
        }

        $schoolYear = SchoolYear::find($this->school_year);

        // Get lessons with pagination first
        $lessonsQuery = $this->student->lessons()
            ->with(['gameActivityLessons.gameActivity', 'classActivities'])
            ->where('school_year_id', $this->school_year)
            ->whereHas('lessonSubjectStudents', function ($query) {
                $query->where('student_id', $this->student->id)
                    ->whereHas('curriculumSubject', function ($q) {
                        $q->whereHas('curriculum', fn($q2) => $q2->where('status', 'active'));
                    });

                if ($this->subject) {
                    $query->whereHas('curriculumSubject', function ($q) {
                        $q->where('subject_id', $this->subject);
                    });
                }
            });

        // Paginate first
        $paginatedLessons = $lessonsQuery->paginate(5);

        // Then filter by quarter (preserve pagination)
        $filteredLessonsCollection = $paginatedLessons->getCollection()
            ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, (int)$this->quarter))
            ->values();

        // Replace the collection in the paginator with the filtered one
        $paginatedLessons->setCollection($filteredLessonsCollection);

        // Add progress percentage + activity grouping
        $paginatedLessons->getCollection()->transform(function ($lesson) {
            $totalActs = $lesson->gameActivityLessons->count() + $lesson->classActivities->count();
            $completed = 0;

            foreach ($lesson->gameActivityLessons as $act) {
                if ($this->student->activityStatus($act) === 'finished') $completed++;
            }
            foreach ($lesson->classActivities as $act) {
                if ($this->student->activityStatus($act) === 'finished') $completed++;
            }

            return [
                'model' => $lesson,
                'game_activities' => $lesson->gameActivityLessons,
                'class_activities' => $lesson->classActivities,
                'percent' => $totalActs ? round(($completed / $totalActs) * 100) : 0,
            ];
        });

        return view('livewire.student-view-modal', [
            'filteredLessons' => $paginatedLessons
        ]);
    }
}
