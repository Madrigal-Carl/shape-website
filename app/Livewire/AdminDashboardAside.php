<?php

namespace App\Livewire;

use Livewire\Component;

class AdminDashboardAside extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public function render()
    {
        return view('livewire.admin-dashboard-aside');
    }
}
