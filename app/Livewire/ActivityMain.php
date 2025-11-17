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
    public $school_year, $school_years, $grade_levels, $grade_level, $quarter;
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

        $this->school_years = SchoolYear::orderBy('name')->get();

        $this->quarter = now()->schoolYear()->currentQuarter();
    }

    public function isEditable($activtiy)
    {
        $schoolYear = now()->schoolYear();

        if (!$schoolYear) {
            return false;
        }

        $currentYear = $schoolYear->id;
        $currentQuarter = $schoolYear->currentQuarter();

        if (!$currentQuarter) {
            return false;
        }

        // Map quarter number to column names
        $map = [
            1 => ['first_quarter_start', 'first_quarter_end'],
            2 => ['second_quarter_start', 'second_quarter_end'],
            3 => ['third_quarter_start', 'third_quarter_end'],
            4 => ['fourth_quarter_start', 'fourth_quarter_end'],
        ];

        [$startAttr, $endAttr] = $map[$currentQuarter];

        $start = $schoolYear->$startAttr;
        $end   = $schoolYear->$endAttr;

        if (!$start || !$end) {
            return false;
        }

        return $activtiy->school_year_id === $currentYear
            && $activtiy->created_at->between($start, $end);
    }

    public function render()
    {
        $schoolYear = SchoolYear::find($this->school_year);

        $activities = ClassActivity::with('curriculumSubject.curriculum', 'curriculumSubject.subject')
            ->withCount(['studentActivities as student_finished_count' => function ($q) {
                $q->where('status', 'finished');
            }])
            ->where('instructor_id', Auth::user()->accountable->id)
            ->where('school_year_id', $this->school_year)
            ->whereHas('curriculumSubject.curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->when(!empty($this->search), function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->quarter, function ($query) use ($schoolYear) {
                switch ((int) $this->quarter) {
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

        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        return view('livewire.activity-main', compact('activities'));
    }
}
