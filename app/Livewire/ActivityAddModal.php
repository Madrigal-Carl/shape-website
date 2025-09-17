<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ActivityAddModal extends Component
{
    public $isOpen = true;

    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('activity-main');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.activity-add-modal');
    }
}
