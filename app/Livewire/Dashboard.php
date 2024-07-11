<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Schedule;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    public $events = [];


    public function mount()
    {
        $this->fetchEvents();
    }

    public function fetchEvents()
    {
        $schedules = Schedule::orderBy('start', 'asc')
            ->where('status', Schedule::APPROVED)
            ->with('team', 'venue')
            ->get();

        foreach ($schedules as $schedule) {
            $this->events[] = [
                'id' => $schedule->id,
                'title' => $schedule->team->thesis_title,
                'teamName' => $schedule->team->name,
                'members' => $schedule->team->members,
                'panelists' => $schedule->team->panelists,
                'venue' => $schedule->venue->name,
                'typeOfDefense' => Schedule::DEFENSE_STATUS[$schedule->type_of_defense],
                'start' => Carbon::parse($schedule->start)->format('Y-m-d H:i:s'),
                'end' => Carbon::parse($schedule->end)->format('Y-m-d H:i:s'),
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
