<?php

namespace App\Livewire;

use Livewire\Component;

class AdminDashboardMain extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public function openQuarterModal()
    {
        $this->dispatch('openModal')->to('quarter-setup-modal');
    }
}
