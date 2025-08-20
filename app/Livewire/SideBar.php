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

    public function mount($sideBarItems = [])
    {
        $this->sideBarItems = $sideBarItems;
        $this->activeSideBar = session('activeSideBar', $this->sideBarItems[0]['name']);
        session(['activeSideBar' => $this->activeSideBar]);
    }

    public function setActiveSideBar($activatedSideBar)
    {
        $this->activeSideBar = $activatedSideBar;
        session(['activeSideBar' => $activatedSideBar]);
        $this->dispatch('setAcivatedSideBar', $activatedSideBar);
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
