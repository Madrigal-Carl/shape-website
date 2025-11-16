<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InstructorAside extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public function render()
    {
        $feeds = Feed::where('group', 'instructor')
            ->orderByDesc('created_at')
            ->limit(15)
            ->get();
        return view('livewire.instructor-aside', compact('feeds'));
    }
}
