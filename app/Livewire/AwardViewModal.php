<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class AwardViewModal extends Component
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
        $this->curriculum_id = null;
    }

    public function render()
    {
        return view('livewire.award-view-modal');
    }
}
