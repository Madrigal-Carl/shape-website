<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LessonMain extends Component
{
    public $status = 'all';
    public $listeners = ['refresh' => '$refresh'];

    public function openAddLessonModal()
    {
        $this->dispatch('openModal')->to('lesson-add-modal');
    }

    public function render()
    {
        $user = Account::with('accountable')->find( Auth::user()->id );
        $lessons = $user->accountable->lessons()
        ->with([
            'subject.curriculums',
        ])
        ->withCount([
            'students',
            'videos',
            'activityLessons',
            'quizzes'
        ])->orderByDesc('created_at')->get();
        return view('livewire.lesson-main', compact('lessons'));
    }
}
