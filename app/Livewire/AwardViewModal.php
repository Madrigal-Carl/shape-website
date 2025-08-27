<?php

namespace App\Livewire;

use App\Models\Award;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class AwardViewModal extends Component
{
    public $isOpen = false;
    public $award_id = null;
    public $award;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->award_id = $id;
        $this->isOpen = true;
        $this->award = Award::with(['students' => function ($query) {
            $query->where('instructor_id', Auth::user()->accountable->id);
        }])
        ->withCount(['students as awardees_count' => function ($query) {
            $query->where('instructor_id', Auth::user()->accountable->id);
        }])
        ->find($this->award_id);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->award_id = null;
    }

    public function render()
    {
        return view('livewire.award-view-modal');
    }
}
