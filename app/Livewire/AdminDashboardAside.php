<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;

class AdminDashboardAside extends Component
{
    public $listeners = ["refresh" => '$refresh'];

    public function render()
    {
        $feeds = Feed::where('group', 'instructor')->orderByDesc('created_at')->limit(12)->get();
        return view('livewire.admin-dashboard-aside', compact('feeds'));
    }
}
