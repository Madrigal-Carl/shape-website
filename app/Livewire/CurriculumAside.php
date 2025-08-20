<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;

class CurriculumAside extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public function render()
    {
        $feeds = Feed::where('group', 'curriculum')->orderByDesc('created_at')->limit(10)->get();
        return view('livewire.curriculum-aside', compact('feeds'));
    }
}
