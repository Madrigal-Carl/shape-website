<?php

namespace App\Livewire;

use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\On;
use App\Models\GameActivity;
use App\Models\Specialization;

class GameActivityHub extends Component
{
    public $isOpen = false;
    public $targetComponent = null;
    public $isOpenActivityView = false;
    public $activities = [], $specializations, $selectedSpecializations, $subjects, $selectedSubjects;
    public $act;
    public $isImagePreviewOpen = false;
    public $previewImage = null;

    public function showImagePreview($imagePath)
    {
        $this->previewImage = $imagePath;
        $this->isImagePreviewOpen = true;
    }

    public function closeImagePreview()
    {
        $this->isImagePreviewOpen = false;
        $this->previewImage = null;
    }

    public function getOrderedSpecializationsProperty()
    {
        return $this->specializations->sortByDesc(function ($spec) {
            return in_array($spec->name, $this->selectedSpecializations ?? []) ? 1 : 0;
        });
    }

    public function getOrderedSubjectsProperty()
    {
        return $this->subjects->sortByDesc(function ($subj) {
            return in_array($subj->id, $this->selectedSubjects ?? []) ? 1 : 0;
        });
    }

    #[On('openModal')]
    public function openModal($curriculumId = null, $subjectId = null)
    {
        $this->isOpen = true;

        $this->selectedSpecializations = [];
        $this->selectedSubjects = [];

        if ($curriculumId) {
            $curriculum = Curriculum::find($curriculumId);
            if ($curriculum) {
                $this->selectedSpecializations = $curriculum
                    ->specializations()
                    ->pluck('name')
                    ->toArray();
            }
        }

        if ($subjectId) {
            $this->selectedSubjects[] = $subjectId;
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
        $this->act = GameActivity::with('specializations', 'gameImages', 'todos')->find($activityId);
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
        $activity = GameActivity::with('specializations')->find($activityId);
        $this->dispatch('swal-toast', icon: 'success', title: 'Activity has been added successfully.');
        $this->dispatch('addActivity', activity: $activity)->to($this->targetComponent);
    }

    public function toggleSpecialization($specialization)
    {
        if (in_array($specialization, $this->selectedSpecializations)) {
            $this->selectedSpecializations = array_diff($this->selectedSpecializations, [$specialization]);
        } else {
            $this->selectedSpecializations[] = $specialization;
        }

        $this->loadActivities();
    }

    public function toggleSubject($subjectId)
    {
        if (in_array($subjectId, $this->selectedSubjects ?? [])) {
            $this->selectedSubjects = array_diff($this->selectedSubjects, [$subjectId]);
        } else {
            $this->selectedSubjects[] = $subjectId;
        }

        $this->loadActivities();
    }

    private function loadActivities()
    {
        $q = GameActivity::with('specializations');

        if (!empty($this->selectedSpecializations)) {
            foreach ($this->selectedSpecializations as $catName) {
                $q->whereHas('specializations', function ($query) use ($catName) {
                    $query->where('specializations.name', $catName);
                });
            }
        }

        if (!empty($this->selectedSubjects)) {
            $q->whereHas('subjects', function ($query) {
                $query->whereIn('subjects.id', $this->selectedSubjects);
            });
        }
        $this->activities = $q->orderByDesc('created_at')->get();
    }

    public function mount($targetComponent = null)
    {
        $this->targetComponent = $targetComponent;

        $this->specializations = Specialization::orderBy('name')->get();
        $this->subjects = Subject::orderBy('name')->get();
    }


    public function render()
    {
        return view('livewire.game-activity-hub');
    }
}
