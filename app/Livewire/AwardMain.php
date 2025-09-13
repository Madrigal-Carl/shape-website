<?php

namespace App\Livewire;

use App\Models\Award;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\StudentAward;
use Illuminate\Support\Facades\Auth;

class AwardMain extends Component
{
    public $awards;
    public $school_year, $school_years, $grade_level = '', $grade_levels;

    public function mount()
    {
        $this->school_year = now()->schoolYear();
        $this->school_years = StudentAward::select('school_year')
            ->distinct()
            ->orderBy('school_year')
            ->pluck('school_year')
            ->toArray();

        $this->grade_levels = Enrollment::whereIn('student_id', Auth::user()->accountable->students->pluck('id'))
            ->pluck('grade_level')
            ->unique()
            ->sort()
            ->values();
    }

    public function openViewAwardModal($id)
    {
        $this->dispatch('openModal', id: $id, school_year: $this->school_year, grade_level: $this->grade_level)->to('award-view-modal');
    }

    public function render()
    {
        $this->awards = Award::withCount([
            'students as awardees_count' => function ($query) {
                $query->where('instructor_id', Auth::user()->accountable->id)
                    ->where('student_awards.school_year', $this->school_year)
                    ->when($this->grade_level && $this->grade_level !== 'all', function ($q) {
                        $q->whereHas('enrollments', function ($enrollmentQuery) {
                            $enrollmentQuery->where('grade_level', $this->grade_level)
                                ->where('school_year', $this->school_year);
                        });
                    });
            }
        ])->get();
        return view('livewire.award-main');
    }
}
