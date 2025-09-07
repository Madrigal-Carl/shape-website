<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;

class AwardAside extends Component
{
    public function render()
    {
        $feeds = Feed::where('group', 'award')->orderByDesc('created_at')->limit(10)->get();
        return view('livewire.award-aside', compact('feeds'));
    }
}
