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
        $curriculums = Curriculum::withCount(['curriculumSubjects', 'students'])
            ->where('instructor_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.curriculum-main', compact('curriculums'));
    }
}
