<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ClassActivity;
use App\Models\StudentActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityViewModal extends Component
{
    public $isOpen = false, $activity_id = null;
    public $activity;
    public $studentsData;

    #[On('openModal')]
    public function openModal($id)
    {
        $this->activity_id = $id;
        $this->isOpen = true;
        $this->activity = ClassActivity::with('curriculumSubject.curriculum', 'curriculumSubject.subject')
            ->withCount('studentActivities')
            ->where('instructor_id', Auth::user()->accountable->id)
            ->first();

        $this->studentsData = StudentActivity::with('student')
            ->join('activity_lessons', 'student_activities.activity_lesson_id', '=', 'activity_lessons.id')
            ->join('logs', 'logs.student_activity_id', '=', 'student_activities.id')
            ->where('activity_lessons.activity_lessonable_type', ClassActivity::class)
            ->where('activity_lessons.activity_lessonable_id', $this->activity->id)
            ->select(
                'student_activities.student_id',
                DB::raw("MAX(logs.attempt_number) as max_attempt"),
                DB::raw("MAX(logs.score) as max_score"),
                DB::raw("SUM(logs.time_spent_seconds) / 60 as total_time_minutes")
            )
            ->groupBy('student_activities.student_id')
            ->with('student') // so you can access full_name
            ->get();
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('activity-main');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.activity-view-modal');
    }
}
