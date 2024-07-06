<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\Manuscript;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class ScheduleDetail extends Component
{
    use WithFileUploads;

    public $manuscript;

    public $schedule;

    public $isDetailsTabSelected = 'false';
    public $isRSCTabSelected = 'false';
    public $isManuscriptTabSelected = 'false';
    public $isHappeningNowStatus = 'false';

    public function mount(Schedule $schedule)
    {
        $schedule->load('team', 'venue');

        $this->schedule = $schedule;

        if (isset(request()->tabSelected))
        {
            if (request()->tabSelected === 'details')
            {
                $this->isDetailsTabSelected = 'true';
            } 

            if (request()->tabSelected === 'rsc')
            {
                $this->isRSCTabSelected = 'true';
            } 

            if (request()->tabSelected === 'manuscript')
            {
                $this->isManuscriptTabSelected = 'true';
            }
        }

        $this->happeningNowStatus();
    }

    public function uploadManuscript()
    {
        $this->validate([
            'manuscript' => 'required|file|mimes:pdf,doc,docx'
        ]);

        $file = $this->manuscript->store('manuscripts');
        Manuscript::create([
            'team_id' => $this->schedule->team->id,
            'user_id' => auth()->user()->id,
            'file_name' => $file
        ]);

        session()->flash('success', 'Manuscript uploaded.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'manuscript'
        ]);
    }

    public function clearManuscript()
    {
        $this->reset('manuscript');
    }

    public function happeningNowStatus()
    {
        $start = Carbon::now()->format('Y-m-d H:i:s');
        $end = Carbon::now()->addHours(2)->format('Y-m-d H:i:s');

        $schedule = Schedule::where(function($query) use ($start, $end) {
            $query->where('start', '<', $end)
                  ->where('end', '>', $start);
        })->exists();

        if ($schedule)
        {
            $this->isHappeningNowStatus = 'true';
        }
    }

    public function clear()
    {
        $this->resetValidation();
    }

    public function render()
    {
        $manuscripts = $this->schedule->team->manuscripts;

        return view('livewire.schedule-detail', [
            'schedule' => $this->schedule,
            'manuscripts' => $manuscripts,
        ]);
    }
}
