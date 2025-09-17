<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ActivityEditModal extends Component
{
    public $isOpen = false, $activity_id = null;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->activity_id = $id;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('activity-main');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.activity-edit-modal');
    }
}
