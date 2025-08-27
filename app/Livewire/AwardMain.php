<?php

namespace App\Livewire;

use App\Models\Award;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AwardMain extends Component
{
    public $awards;
    public function openViewAwardModal($id)
    {
        $this->dispatch('openModal', id: $id)->to('award-view-modal');
    }

    public function render()
    {
        $this->awards = Award::withCount([
            'students as awardees_count' => function ($query) {
                $query->where('instructor_id', Auth::user()->accountable->id);
            }
        ])->get();
        return view('livewire.award-main');
    }
}
