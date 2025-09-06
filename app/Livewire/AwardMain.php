<?php

namespace App\Livewire;

use App\Models\Award;
use Livewire\Component;
use App\Models\StudentAward;
use Illuminate\Support\Facades\Auth;

class AwardMain extends Component
{
    public $awards;
    public $school_year, $school_years;

    public function mount()
    {
        $this->school_year = now()->schoolYear();
        $this->school_years = StudentAward::select('school_year')
            ->distinct()
            ->orderBy('school_year')
            ->pluck('school_year')
            ->toArray();
    }

    public function openViewAwardModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('award-view-modal');
    }

    public function render()
    {
        $this->awards = Award::withCount([
            'students as awardees_count' => function ($query) {
                $query->where('instructor_id', Auth::user()->accountable->id)
                    ->where('student_awards.school_year', $this->school_year);
            }
        ])->get();
        return view('livewire.award-main');
    }
}
