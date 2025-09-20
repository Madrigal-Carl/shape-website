<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SchoolYear;

class AdminDashboardMain extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public $shouldOpenModal = false;

    public function openQuarterModal()
    {
        $this->dispatch('openModal')->to('quarter-setup-modal');
    }
    public function render()
    {
        $latest = SchoolYear::latest('fourth_quarter_end')->first();

        if (!$latest || $latest->hasEnded()) {
            $this->shouldOpenModal = true;
        }

        return view('livewire.admin-dashboard-main');
    }
}
