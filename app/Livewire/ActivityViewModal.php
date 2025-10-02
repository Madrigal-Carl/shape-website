<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ClassActivity;
use App\Models\StudentActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityViewModal extends Component
{
    public $isOpen = false, $activity_id = null;
    public $activity;
    public $studentsData;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->activity_id = $id;
        $this->isOpen = true;
        $this->activity = ClassActivity::with('curriculumSubject.curriculum', 'curriculumSubject.subject')
            ->withCount('studentActivities')
            ->where('instructor_id', Auth::user()->accountable->id)
            ->find($this->activity_id);

        $this->studentsData = $this->activity->studentActivities
            ->sortByDesc(function ($sa) {
                return $sa->status === 'finished';
            })
            ->map(function ($sa) {
                return [
                    'id'             => $sa->student->id,
                    'fullname'       => $sa->student->fullname,
                    'disability_type' => $sa->student->disability_type,
                    'path'           => $sa->student->path,
                    'status'         => $sa->status,
                ];
            })
            ->values();
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('activity-main');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.activity-view-modal');
    }
}
