<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use App\Models\Enrollment;

class AdminDashboardAside extends Component
{
    public $listeners = ["refresh" => '$refresh'];

    public function approve($id)
    {
        Enrollment::where('id', $id)->update([
            'status' => 'active',
        ]);

        $this->dispatch('refresh');
    }

    public function decline($id)
    {
        Enrollment::where('id', $id)->update([
            'status' => 'declined',
        ]);

        $this->dispatch('refresh');
    }

    public function render()
    {
        $currentSchoolYear = now()->schoolYear();
        $enrollments = Enrollment::with('student', 'instructor')
            ->where('school_year_id', $currentSchoolYear->id)
            ->whereBetween('created_at', [
                $currentSchoolYear->second_quarter_start,
                $currentSchoolYear->fourth_quarter_end
            ])
            ->orderByRaw("CASE
                WHEN status = 'pending' THEN 0
                ELSE 1
            END")
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('livewire.admin-dashboard-aside', compact('enrollments'));
    }
}
