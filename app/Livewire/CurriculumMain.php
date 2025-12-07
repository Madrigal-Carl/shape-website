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
        $curriculum = Curriculum::with('specializations')
            ->where('instructor_id', Auth::user()->accountable->id)
            ->findOrFail($id);

        if ($curriculum->status === 'inactive') {
            $conflict = false;
            foreach ($curriculum->specializations as $specialization) {
                $activeCurriculum = $specialization->curriculums()
                    ->where('status', 'active')
                    ->where('curricula.id', '!=', $curriculum->id)
                    ->where('instructor_id', Auth::user()->accountable->id)
                    ->first();

                if ($activeCurriculum) {
                    $conflict = true;
                    break;
                }
            }

            if ($conflict) {
                $this->dispatch('swal-toast', icon: 'error', title: 'Cannot activate. Another curriculum in the same specialization is already active.');
                return;
            }

            $curriculum->update(['status' => 'active']);
            $this->dispatch('swal-toast', icon: 'success', title: 'Curriculum has been activated.');
        } else {
            $curriculum->update(['status' => 'inactive']);
            $this->dispatch('swal-toast', icon: 'warning', title: 'Curriculum has been deactivated.');
        }
    }

    public function isToggleDisabled($curriculum)
    {
        if ($curriculum->status === 'inactive') {
            foreach ($curriculum->specializations as $specialization) {
                $activeCurriculum = $specialization->curriculums()
                    ->where('status', 'active')
                    ->where('curricula.id', '!=', $curriculum->id) // prefix table name
                    ->where('instructor_id', Auth::user()->accountable->id)
                    ->first();

                if ($activeCurriculum) {
                    return true;
                }
            }
        }

        return false;
    }

    public function render()
    {
        $curriculums = Curriculum::with('curriculumSubjects', 'gradeLevel')
            ->where('instructor_id', Auth::user()->accountable->id)
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->when(!empty($this->search), function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.curriculum-main', compact('curriculums'));
    }
}
