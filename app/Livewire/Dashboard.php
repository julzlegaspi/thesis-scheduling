<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Schedule;

class Dashboard extends Component
{
    public $events = [];

    public $listeners = ['showEvent'];

    public function mount()
    {
        $this->fetchEvents();
    }

    public function fetchEvents()
    {
        $schedules = Schedule::orderBy('start', 'asc')->where('status', Schedule::APPROVED)->get();

        foreach ($schedules as $schedule) {
            $this->events[] = [
                'title' => $schedule->team->thesis_title,
                'start' => Carbon::parse($schedule->start)->format('Y-m-d H:i:s'),
                'end' => Carbon::parse($schedule->end)->format('Y-m-d H:i:s'),
            ];
        }
    }

    public function updateEvents()
    {
        $this->fetchEvents();
        $this->emit('eventUpdated', $this->events);
    }

    public function showEvent($event)
    {
        dd($event);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
