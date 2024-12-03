<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Schedule;

class OnQueue extends Component
{
    public function render()
    {
        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s'); // Get the current date and time

        $futureDateTime = Carbon::parse($currentDateTime)->addHours(2)->format('Y-m-d H:i:s');

        $ongoingSchedule = Schedule::where('start', '<=', $currentDateTime)
            ->where('end', '>=', $currentDateTime)
            ->where('status', Schedule::APPROVED)
            ->where('custom_status', null)
            ->first();

        $upcomingSchedules = Schedule::where('end', '>=', $futureDateTime)
            ->where('status', Schedule::APPROVED)
            ->where('custom_status', null)
            ->orderBy('start', 'asc')
            ->take(3)
            ->get();
            
        return view('livewire.on-queue', [
            'ongoingSchedule' => $ongoingSchedule,
            'upcomingSchedules' => $upcomingSchedules,
        ])->layout('layouts.queue');
    }
}
