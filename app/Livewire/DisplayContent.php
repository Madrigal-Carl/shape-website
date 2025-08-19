<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class DisplayContent extends Component
{
    public $sideBarItems;
    public $activeSideBar = '';

    public function mount($sideBarItems = [])
    {
        $this->sideBarItems = $sideBarItems;
        $this->activeSideBar = session('activeSideBar', $this->sideBarItem[0]['name'] ?? '');
    }

    #[On('setAcivatedSideBar')]
    public function updateActive($activatedSideBar)
    {
        $this->activeSideBar = $activatedSideBar;
    }

    public function render()
    {
        return view('livewire.display-content');
    }
}
