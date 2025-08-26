<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Activity;
use Livewire\Attributes\On;
use App\Models\Specialization;

class ActivityHub extends Component
{
    public $isOpen = false;
    public $targetComponent = null;
    public $isOpenActivityView = false;
    public $activities = [], $categories = [], $selectedCategories = [];
    public $act;


    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->activities = Activity::all();
        $this->loadActivities();
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function viewActivity($activityId)
    {
        $this->act = null;
        $this->act = Activity::with('specializations')->find($activityId);
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
        $activity = Activity::with('specializations')->find($activityId);
        $this->dispatch('swal-toast', icon : 'success', title : 'Activity has been added successfully.');
        $this->dispatch('addActivity', activity: $activity)->to($this->targetComponent);
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
        }

        $this->loadActivities();
    }

    private function loadActivities()
    {
        $q = Activity::with('specializations');

        if (!empty($this->selectedCategories)) {
            foreach ($this->selectedCategories as $catName) {
                $q->whereHas('specializations', function ($query) use ($catName) {
                    $query->where('specializations.name', $catName);
                });
            }
        }

        $this->activities = $q->orderByDesc('created_at')->get();
    }


    public function mount($targetComponent = null)
    {
        $this->targetComponent = $targetComponent;
        $this->categories = Specialization::orderBy('name')->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.activity-hub');
    }
}
