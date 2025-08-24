<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Activity;
use Livewire\Attributes\On;

class AddActivityHub extends Component
{
    public $isOpen = false;
    public $isOpenActivityView = false;
    public $activities = [];
    public $selectedCategories = [];
    public $act;


    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->activities = Activity::all();
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function viewActivity($activityId)
    {
        $this->act = null;
        $this->act = Activity::find($activityId);
        $this->openViewActivity();
    }

    public function openViewActivity()
    {
        $this->isOpenActivityView = true;
    }

    public function closeActivityView()
    {
        $this->isOpenActivityView = false;
        $this->act = null;
    }

    public function addActivity($activityId)
    {
        $activity = Activity::find($activityId);
        $this->dispatch('swal-toast', icon : 'success', title : 'Activity has been added successfully.');
        $this->dispatch('addActivity', activity: $activity)->to('lesson-add-modal');
    }

    public function toggleCategory($category)
    {
        if (in_array($category, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$category]);
        } else {
            $this->selectedCategories[] = $category;
        }

        $this->loadActivities();
    }

    private function loadActivities()
    {
        $q = Activity::query();

        foreach ($this->selectedCategories as $cat) {
            $q->whereJsonContains('category', $cat);
        }

        $this->activities = $q->orderByDesc('created_at')->get();
    }

    public function render()
    {
        return view('livewire.add-activity-hub');
    }
}
