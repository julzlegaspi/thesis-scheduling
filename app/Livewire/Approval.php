<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;

class Approval extends Component
{
    public function render()
    {
        $userId = auth()->user()->id;
        $pendingSchedules = Schedule::where('status', Schedule::FOR_PANELIST_APPROVAL)
            ->whereHas('team.panelists', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->get();


        return view('livewire.approval', [
            'pendingSchedules' => $pendingSchedules,
        ]);
    }
}
