<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CurriculumAside extends Component
{
    public $listeners = ["refresh" => '$refresh'];
    public function render()
    {

        $feeds = Feed::where('group', 'curriculum')
            ->where('notifiable_id', Auth::user()->accountable->id)
            ->where('notifiable_type', get_class(Auth::user()->accountable))
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        return view('livewire.curriculum-aside', compact('feeds'));
    }
}
