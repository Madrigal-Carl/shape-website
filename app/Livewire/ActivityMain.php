<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClassActivity;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class ActivityMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
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

    public function render()
    {
        $activities = ClassActivity::with('curriculumSubject.curriculum', 'curriculumSubject.subject')
            ->withCount('studentActivities')
            ->where('instructor_id', Auth::user()->accountable->id)
            ->whereHas('curriculumSubject.curriculum', function ($q) {
                $q->where('status', 'active');
            })
            ->when(!empty($this->search), function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view(
            'livewire.activity-main',
            compact('activities')
        );
    }
}
