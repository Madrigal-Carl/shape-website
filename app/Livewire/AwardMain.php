<?php

namespace App\Livewire;

use Livewire\Component;

class AwardMain extends Component
{
    public function openViewAwardModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('award-view-modal');
    }

    public function render()
    {
        return view('livewire.award-main');
    }
}
