<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\SchoolYear;
use Livewire\Attributes\On;
use Illuminate\Validation\ValidationException;

class QuarterSetupModal extends Component
{
    public $isOpen = false;

    public $first_quarter_start;
    public $first_quarter_end;
    public $second_quarter_start;
    public $second_quarter_end;
    public $third_quarter_start;
    public $third_quarter_end;
    public $fourth_quarter_start;
    public $fourth_quarter_end;

    public $schoolYearId; // Track the current school year for updates

    #[On('openModal')]
    public function openModal()
    {
        $latest = SchoolYear::latest('fourth_quarter_end')->first();

        if ($latest && !$latest->hasEnded()) {
            $this->schoolYearId         = $latest->id;
            $this->first_quarter_start  = $latest->first_quarter_start;
            $this->first_quarter_end    = $latest->first_quarter_end;
            $this->second_quarter_start = $latest->second_quarter_start;
            $this->second_quarter_end   = $latest->second_quarter_end;
            $this->third_quarter_start  = $latest->third_quarter_start;
            $this->third_quarter_end    = $latest->third_quarter_end;
            $this->fourth_quarter_start = $latest->fourth_quarter_start;
            $this->fourth_quarter_end   = $latest->fourth_quarter_end;
        } else {
            $this->reset([
                'schoolYearId',
                'first_quarter_start',
                'first_quarter_end',
                'second_quarter_start',
                'second_quarter_end',
                'third_quarter_start',
                'third_quarter_end',
                'fourth_quarter_start',
                'fourth_quarter_end',
            ]);
        }

        $this->isOpen = true;
    }

    public function mount($isOpen = false)
    {
        $this->isOpen = $isOpen;
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('admin-dashboard-main');
        $this->isOpen = false;
    }

    public function saveQuarters()
    {
        try {
            $this->validate([
                'first_quarter_start'  => 'required',
                'first_quarter_end'    => 'required|after:first_quarter_start',
                'second_quarter_start' => 'required|after:first_quarter_end',
                'second_quarter_end'   => 'required|after:second_quarter_start',
                'third_quarter_start'  => 'required|after:second_quarter_end',
                'third_quarter_end'    => 'required|after:third_quarter_start',
                'fourth_quarter_start' => 'required|after:third_quarter_end',
                'fourth_quarter_end'   => 'required|after:fourth_quarter_start',
            ], [
                'first_quarter_start.required' => 'The 1st quarter start date is required.',
                'first_quarter_end.required'   => 'The 1st quarter end date is required.',
                'first_quarter_end.after'      => 'The 1st quarter end must be after the start date.',
                'second_quarter_start.required' => 'The 2nd quarter start date is required.',
                'second_quarter_start.after'    => 'The 2nd quarter start must be after the 1st quarter end.',
                'second_quarter_end.required'   => 'The 2nd quarter end date is required.',
                'second_quarter_end.after'      => 'The 2nd quarter end must be after the start date.',
                'third_quarter_start.required' => 'The 3rd quarter start date is required.',
                'third_quarter_start.after'    => 'The 3rd quarter start must be after the 2nd quarter end.',
                'third_quarter_end.required'   => 'The 3rd quarter end date is required.',
                'third_quarter_end.after'      => 'The 3rd quarter end must be after the start date.',
                'fourth_quarter_start.required' => 'The 4th quarter start date is required.',
                'fourth_quarter_start.after'    => 'The 4th quarter start must be after the 3rd quarter end.',
                'fourth_quarter_end.required'   => 'The 4th quarter end date is required.',
                'fourth_quarter_end.after'      => 'The 4th quarter end must be after the start date.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon: 'error', title: $message);
        }


        if ($this->schoolYearId) {
            $schoolYear = SchoolYear::find($this->schoolYearId);
            $schoolYear->update($this->getData());

            $this->dispatch('swal-toast', [
                'icon'  => 'success',
                'title' => 'School year quarters updated successfully!',
            ]);
        } else {
            SchoolYear::create($this->getData());

            $this->dispatch('swal-toast', [
                'icon'  => 'success',
                'title' => 'School year quarters created successfully!',
            ]);
        }

        $this->closeModal();
    }

    protected function getData()
    {
        return [
            'first_quarter_start'  => $this->first_quarter_start,
            'first_quarter_end'    => $this->first_quarter_end,
            'second_quarter_start' => $this->second_quarter_start,
            'second_quarter_end'   => $this->second_quarter_end,
            'third_quarter_start'  => $this->third_quarter_start,
            'third_quarter_end'    => $this->third_quarter_end,
            'fourth_quarter_start' => $this->fourth_quarter_start,
            'fourth_quarter_end'   => $this->fourth_quarter_end,
        ];
    }

    public function updatedFirstQuarterEnd($value)
    {
        $this->second_quarter_start = Carbon::parse($value)->addDay()->toDateString();
    }

    public function updatedSecondQuarterEnd($value)
    {
        $this->third_quarter_start = Carbon::parse($value)->addDay()->toDateString();
    }

    public function updatedThirdQuarterEnd($value)
    {
        $this->fourth_quarter_start = Carbon::parse($value)->addDay()->toDateString();
    }

    public function render()
    {
        return view('livewire.quarter-setup-modal');
    }
}
