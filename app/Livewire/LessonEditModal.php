<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class LessonEditModal extends Component
{
    use WithFileUploads;
    public $isOpen = false;
    public function render()
    {
        return view('livewire.lesson-edit-modal');
    }
}
