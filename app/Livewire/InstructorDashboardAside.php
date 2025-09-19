<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;

class InstructorDashboardAside extends Component
{
    public $feeds;

    public function mount()
    {
        $this->feeds = Feed::whereIn('group', ['student', 'award', 'curriculum', 'lesson'])
            ->latest()
            ->take(12)
            ->get();
    }

    public function render()
    {
        return view('livewire.instructor-dashboard-aside');
    }
}
