<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;

class AwardAside extends Component
{
    public function render()
    {
        $feeds = Feed::where('group', 'award')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        return view('livewire.award-aside', compact('feeds'));
    }
}
