<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule as ScheduleModel;

class Schedule extends Component
{
    public function render()
    {
        $schedules = ScheduleModel::orderBy('start', 'desc')->with('team', 'venue')->paginate();
        return view('livewire.schedule', [
            'schedules' => $schedules,
        ]);
    }
}
