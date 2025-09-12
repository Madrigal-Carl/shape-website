<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Activity;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\Specialization;
use App\Models\CurriculumSubject;
use Illuminate\Support\Facades\Auth;

class ActivityHub extends Component
{
    public $isOpen = false;
    public $targetComponent = null;
    public $isOpenActivityView = false;
    public $activities = [], $specializations = [], $selectedSpecializations = [];
    public $act;
    public $isPreviewOpen = false;
    public $previewImages = [];
    public $previewIndex = 0;


    #[On('openModal')]
    public function openModal($curriculumId = null)
    {
        $this->isOpen = true;

        if ($curriculumId) {
            $curriculum = Curriculum::find($curriculumId);
            if ($curriculum) {
                $this->selectedSpecializations = $curriculum
                    ->specializations()
                    ->pluck('name')
                    ->toArray();
            } else {
                $this->selectedSpecializations = [];
            }
        } else {
            $this->selectedSpecializations = [];
        }

        $this->loadActivities();
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function viewActivity($activityId)
    {
        $this->act = null;
        $this->act = Activity::with('specializations', 'activityImages')->find($activityId);
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
        $this->dispatch('swal-toast', icon: 'success', title: 'Activity has been added successfully.');
        $this->dispatch('addActivity', activity: $activity)->to($this->targetComponent);
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedSpecializations)) {
            $this->selectedSpecializations = array_diff($this->selectedSpecializations, [$categoryId]);
        } else {
            $this->selectedSpecializations[] = $categoryId;
        }

        $this->loadActivities();
    }

    private function loadActivities()
    {
        $q = Activity::with('specializations');

        if (!empty($this->selectedSpecializations)) {
            foreach ($this->selectedSpecializations as $catName) {
                $q->whereHas('specializations', function ($query) use ($catName) {
                    $query->where('specializations.name', $catName);
                });
            }
        }

        $this->activities = $q->orderByDesc('created_at')->get();
    }

    public function openPreview($activityId, $imageIndex = 0)
    {
        $activity = Activity::with('activityImages')->find($activityId);

        if (!$activity) return;

        $this->previewImages = $activity->activityImages->pluck('path')->toArray();
        $this->previewIndex = $imageIndex;
        $this->isPreviewOpen = true;
    }

    public function closePreview()
    {
        $this->isPreviewOpen = false;
        $this->previewImages = [];
        $this->previewIndex = 0;
    }

    public function nextImage()
    {
        if (!empty($this->previewImages)) {
            $this->previewIndex = ($this->previewIndex + 1) % count($this->previewImages);
        }
    }

    public function prevImage()
    {
        if (!empty($this->previewImages)) {
            $this->previewIndex = ($this->previewIndex - 1 + count($this->previewImages)) % count($this->previewImages);
        }
    }

    public function setImage($index)
    {
        if (isset($this->previewImages[$index])) {
            $this->previewIndex = $index;
        }
    }

    public function mount($targetComponent = null)
    {
        $this->targetComponent = $targetComponent;

        $this->specializations = Specialization::orderBy('name')->pluck('name')->toArray();
    }


    public function render()
    {
        return view('livewire.activity-hub');
    }
}
