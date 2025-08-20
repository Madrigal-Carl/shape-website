<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curriculum;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;

class CurriculumMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $status = 'all';
    public $listeners = ["refresh" => '$refresh'];

    public function openAddCurriculumModal()
    {
        $this->dispatch('openModal')->to('curriculum-add-modal');
    }

    public function openEditCurriculumModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('curriculum-edit-modal');
    }

    public function openViewCurriculumModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('curriculum-view-modal');
    }

    public function render()
    {
        $curriculums = Curriculum::withCount('subjects')
            ->where('instructor_id', Auth::id())
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.curriculum-main', compact('curriculums'));
    }
}
