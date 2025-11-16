<?php

namespace App\Livewire;

use App\Models\Award;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class AwardViewModal extends Component
{
    public $isOpen = false;
    public $award_id = null;
    public $award;

    #[On('openModal')]
    public function openModal($id, $school_year, $grade_level)
    {
        $this->award_id = $id;
        $this->isOpen = true;
        $this->award = Award::with(['students' => function ($query) use ($school_year, $grade_level) {
            $query->whereNull('student_awards.deleted_at')
                ->whereHas('enrollments', function ($enrollmentQuery) use ($school_year, $grade_level) {
                    $enrollmentQuery->where('instructor_id', Auth::user()->accountable->id)
                        ->where('school_year_id', $school_year)
                        ->when($grade_level && $grade_level !== 'all', function ($q) use ($grade_level) {
                            $q->where('grade_level_id', $grade_level);
                        });
                });
        }])
            ->withCount(['students as awardees_count' => function ($query) use ($school_year, $grade_level) {
                $query->whereNull('student_awards.deleted_at')
                    ->whereHas('enrollments', function ($enrollmentQuery) use ($school_year, $grade_level) {
                        $enrollmentQuery->where('instructor_id', Auth::user()->accountable->id)
                            ->where('school_year_id', $school_year)
                            ->when($grade_level && $grade_level !== 'all', function ($q) use ($grade_level) {
                                $q->where('grade_level_id', $grade_level);
                            });
                    });
            }])
            ->find($this->award_id);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->award_id = null;
    }

    public function render()
    {
        return view('livewire.award-view-modal');
    }
}
