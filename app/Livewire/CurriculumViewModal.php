<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;

class CurriculumViewModal extends Component
{
    public $isOpen = false;
    public $curriculum_id = null;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->curriculum_id = $id;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        $curriculum = Curriculum::with(['curriculumSubjects.subject',
        'curriculumSubjects' => function ($query) {
            $query->withCount('lessons');
        }])->find($this->curriculum_id);
        return view('livewire.curriculum-view-modal', compact('curriculum'));
    }

}
