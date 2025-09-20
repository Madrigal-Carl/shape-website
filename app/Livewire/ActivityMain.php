<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SchoolYear;
use Livewire\WithPagination;
use App\Models\ClassActivity;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class ActivityMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $school_year, $school_years, $grade_levels, $quarter;
    public $listeners = ["refresh" => '$refresh'];

    public function openAddActivityModal()
    {
        $this->dispatch('openModal')->to('activity-add-modal');
    }

    public function openEditActivityModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('activity-edit-modal');
    }

    public function openViewActivityModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('activity-view-modal');
    }


    public function mount()
    {
        $this->school_year = now()->schoolYear()->id;

        $this->school_years = ClassActivity::where('instructor_id', Auth::user()->accountable->id)
            ->with('schoolYear')
            ->get()
            ->pluck('schoolYear')
            ->unique('id')
            ->sortBy('name')
            ->values();

        $this->quarter = now()->schoolYear()->currentQuarter();
    }

    public function render()
    {
        $schoolYear = SchoolYear::find($this->school_year);

        $activities = ClassActivity::with('curriculumSubject.curriculum', 'curriculumSubject.subject')
            ->withCount('studentActivities')
            ->where('instructor_id', Auth::user()->accountable->id)
            ->where('school_year_id', $this->school_year)
            ->whereHas('curriculumSubject.curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->when(!empty($this->search), function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->quarter, function ($query) use ($schoolYear) {
                switch ($this->quarter) {
                    case 1:
                        $query->whereBetween('created_at', [
                            $schoolYear->first_quarter_start,
                            $schoolYear->first_quarter_end,
                        ]);
                        break;
                    case 2:
                        $query->whereBetween('created_at', [
                            $schoolYear->second_quarter_start,
                            $schoolYear->second_quarter_end,
                        ]);
                        break;
                    case 3:
                        $query->whereBetween('created_at', [
                            $schoolYear->third_quarter_start,
                            $schoolYear->third_quarter_end,
                        ]);
                        break;
                    case 4:
                        $query->whereBetween('created_at', [
                            $schoolYear->fourth_quarter_start,
                            $schoolYear->fourth_quarter_end,
                        ]);
                        break;
                }
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.activity-main', compact('activities'));
    }
}
