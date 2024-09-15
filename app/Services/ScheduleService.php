<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Schedule;

class ScheduleService
{
    private int $team_id;
    private string $start;
    private array $panelists;

    public function __construct(
        string $team_id,
        string $start,
        array $panelists
    )
    {
        $this->team_id = $team_id;
        $this->start = $start;
        $this->panelists = $panelists;
    }

    public function checkScheduleConflict()
    {
        $panelists = $this->panelists;
        $end = Carbon::parse($this->start)->addHours(2);
        // Convert start and end to Carbon instances
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($end);

        // Check for exact conflicts
        $exactConflict = Schedule::where('team_id', $this->team_id)->first();

        if ($exactConflict) {
            return $exactConflict;
        }

        // Check for overlapping conflicts
        $overlappingConflict = Schedule::where(function ($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end])
                    ->orWhereBetween('end', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            })
            ->whereHas('team.panelists', function ($query) use ($panelists) {
                $query->whereIn('users.id', $panelists);
            })
            ->first();

        return $overlappingConflict;
    }

    public function checkScheduleConflictForStudent()
    {
        $panelists = $this->panelists;
        $end = Carbon::parse($this->start)->addHours(2);
        // Convert start and end to Carbon instances
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($end);

        // Check for overlapping conflicts
        $overlappingConflict = Schedule::where(function ($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end])
                    ->orWhereBetween('end', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            })
            ->whereHas('team.panelists', function ($query) use ($panelists) {
                $query->whereIn('users.id', $panelists);
            })
            ->first();

        return $overlappingConflict;
    }
}