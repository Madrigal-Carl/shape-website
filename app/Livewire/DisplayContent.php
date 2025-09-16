<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class DisplayContent extends Component
{
    public $sideBarItems;
    public $activeSideBar = '';
    public $activeSubContent = null;

    public function mount($sideBarItems = [])
    {
        $this->sideBarItems = $sideBarItems;
        $this->activeSideBar = session('activeSideBar', $this->sideBarItems[0]['name'] ?? '');
        $this->activeSubContent = session('activeSubContent', null);
    }

    #[On('setAcivatedSideBar')]
    public function updateActive($activated)
    {
        // activated may be either a parent or a child
        $this->activeSideBar = session('activeSideBar', $this->activeSideBar);
        $this->activeSubContent = session('activeSubContent', $this->activeSubContent);
    }

    public function render()
    {
        return view('livewire.display-content');
    }
}
