<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

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
        // $curriculums = Curriculum::with('curriculumSubjects')
        //     ->where('instructor_id', Auth::user()->accountable->id)
        //     ->when($this->status !== 'all', function ($query) {
        //         $query->where('status', $this->status);
        //     })
        //     ->when(!empty($this->search), function ($query) {
        //         $query->where('name', 'like', '%' . $this->search . '%');
        //     })
        //     ->orderByDesc('created_at')
        //     ->paginate(10);

        return view(
            'livewire.activity-main',
            // compact('curriculums')
        );
    }
}
