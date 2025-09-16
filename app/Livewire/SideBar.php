<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SideBar extends Component
{
    public $sideBarItems;
    public $activeSideBar;
    public $activeSubContent = null;
    public $expanded = null; // which parent is expanded

    public function mount($sideBarItems = [])
    {
        $this->sideBarItems = $sideBarItems;
        $this->activeSideBar = session('activeSideBar', $this->sideBarItems[0]['name']);
        $this->activeSubContent = session('activeSubContent', null);
        $this->expanded = session('expanded', null);
    }

    public function setActiveSideBar($activatedSideBar)
    {
        $this->activeSideBar = $activatedSideBar;
        $this->activeSubContent = null; // reset subcontent highlight
        $this->expanded = $activatedSideBar; // expand only this one

        session([
            'activeSideBar' => $this->activeSideBar,
            'activeSubContent' => null,
            'expanded' => $this->expanded,
        ]);

        $this->dispatch('setAcivatedSideBar', $activatedSideBar);
    }

    public function setActiveSubContent($parent, $subItem)
    {
        $this->activeSideBar = $parent; // still keep parent open
        $this->activeSubContent = $subItem;
        $this->expanded = $parent;

        session([
            'activeSideBar' => $parent,
            'activeSubContent' => $subItem,
            'expanded' => $this->expanded,
        ]);

        $this->dispatch('setAcivatedSideBar', $subItem);
    }

    #[On('logout')]
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function logoutConfirm()
    {
        $this->dispatch('show-logout-confirm');
    }

    public function render()
    {
        return view('livewire.side-bar');
    }
}
