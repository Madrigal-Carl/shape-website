<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;

class StudentAside extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public function render()
    {
        $feeds = Feed::where('group', 'student')->orderByDesc('created_at')->limit(10)->get();
        return view('livewire.student-aside', compact('feeds'));
    }
}
