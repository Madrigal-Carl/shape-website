<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;

class InstructorDashboardAside extends Component
{
    public $feeds;

    public function mount()
    {
        $groups = ['student', 'award', 'curriculum', 'lesson'];

        $feeds = collect();

        foreach ($groups as $group) {
            $feeds = $feeds->merge(
                Feed::where('group', $group)
                    ->latest()
                    ->take(3)
                    ->get()
            );
        }

        $this->feeds = $feeds->sortByDesc('created_at')->values();
    }

    public function render()
    {
        return view('livewire.instructor-dashboard-aside');
    }
}
