<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AwardAside extends Component
{
    public function render()
    {
        $feeds = Feed::where('group', 'award')
            ->where('notifiable_id', Auth::user()->accountable->id)
            ->where('notifiable_type', get_class(Auth::user()->accountable))
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        return view('livewire.award-aside', compact('feeds'));
    }
}
