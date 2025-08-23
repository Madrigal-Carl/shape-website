<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curriculum;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class CurriculumMain extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $status = 'all';
    public $search = '';
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

    public function toggleStatus($id)
    {
        $curriculum = Curriculum::where('instructor_id', Auth::id())->findOrFail($id);
        if ($curriculum->status === 'inactive') {
            Curriculum::where('instructor_id', Auth::id())
                ->where('id', '!=', $curriculum->id)
                ->update(['status' => 'inactive']);

            $curriculum->update(['status' => 'active']);
            $this->dispatch('swal-toast', icon : 'success', title : 'Curriculum has been activated.');
            return $this->resetPage();
        }
        $curriculum->update(['status' => 'inactive']);
        $this->dispatch('swal-toast', icon : 'warning', title : 'Curriculum has been deactived.');
        return $this->resetPage();
    }


    public function render()
    {
        $curriculums = Curriculum::with('curriculumSubjects')
            ->where('instructor_id', Auth::id())
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->when(!empty($this->search), function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderByRaw("FIELD(status, 'active', 'inactive')")
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.curriculum-main', compact('curriculums'));
    }
}
