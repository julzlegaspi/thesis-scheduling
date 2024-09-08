<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Venue;
use Livewire\Component;
use App\Models\Schedule as ScheduleModel;
use Livewire\WithPagination;

class Schedule extends Component
{
    use WithPagination;

    public int $id;

    public $team = '';

    public $thesisTitle = '';

    public $teamMembers = '';

    public $panelists = '';

    public $venue;

    public $start;

    public $type;

    protected $rules = [
        'team' => 'required',
        'venue' => 'required',
        'start' => 'required|after_or_equal:now',
        'type' => 'required|integer',
    ];

    public function store()
    {
        $this->validate();

        if (ScheduleModel::where('team_id', $this->team)->first()) {
            return $this->addError('team', 'Unable to set the schedule. It has already been scheduled.');
        }

        ScheduleModel::create([
            'user_id' => auth()->user()->id,
            'team_id' => $this->team,
            'venue_id' => $this->venue,
            'start' => $this->start,
            'end' => Carbon::parse($this->start)->addHours(2),
            'status' => ScheduleModel::FOR_PANELIST_APPROVAL,
            'type_of_defense' => $this->type,
        ]);

        session()->flash('success', 'Schedule created.');

        $this->redirect(Schedule::class);
    }

    public function edit(ScheduleModel $schedule)
    {
        $schedule->load('team', 'venue');
        $this->id = $schedule->id;
        $this->team = $schedule->team_id;
        $this->getTeamInfo();
        $this->venue = $schedule->venue->id;
        $this->start = $schedule->start;
        $this->type = $schedule->type_of_defense;
    }

    public function update()
    {
        $this->validate();
        
        $schedule = ScheduleModel::where('id', $this->id)->first();
        $schedule->team_id = $this->team;
        $schedule->venue_id = $this->venue;
        $schedule->user_id = auth()->user()->id;
        $schedule->start = $this->start;
        $schedule->end = Carbon::parse($this->start)->addHours(2);
        $schedule->type_of_defense = $this->type;
        $schedule->save();

        session()->flash('success', 'Schedule updated.');

        $this->redirect(Schedule::class);
    }

    public function destroy(ScheduleModel $schedule)
    {
        $schedule->delete();

        session()->flash('success', 'Schedule deleted.');

        $this->redirect(Schedule::class);
    }

    public function updateScheduleStatus(ScheduleModel $schedule, $status)
    {
        if ($status === 'thesis-defended')
        {
            $schedule->status = ScheduleModel::THESIS_DEFENDED;
            $schedule->save();
        } 

        if ($status === 're-defense')
        {
            $schedule->status = ScheduleModel::RE_DEFENSE;
            $schedule->save();
        }

        session()->flash('success', 'Status update.');

        $this->redirect(Schedule::class);
    }

    public function clear()
    {
        $this->team = '';
        $this->thesisTitle = '';
        $this->teamMembers = '';
        $this->panelists = '';
        $this->venue = '';
        $this->start = '';
        $this->resetValidation();
    }

    public function checkConflict()
    {
        if (ScheduleModel::where('team_id', $this->team)->first()) {
            return $this->addError('team', 'Unable to set the schedule. It has already been scheduled.');
        }
        // $start = Carbon::parse($this->start)->format('Y-m-d H:i:s');
        // $end = Carbon::parse($this->start)
        //     ->addHours(2)
        //     ->format('Y-m-d H:i:s');

        // $conflict = ScheduleModel::where(function ($query) use ($start, $end) {
        //     $query->where('start', '<', $end)->where('end', '>', $start);
        // })->exists();

        // if ($conflict) {
        //     return $this->addError('start', 'The selected time slot conflicts with an existing schedule.');
        // }
    }

    public function getTeamInfo()
    {
        if ($this->team != '') {
            $this->resetValidation();
            $teamInfo = Team::where('id', $this->team)
                ->with('members', 'panelists')
                ->first();

            $this->thesisTitle = $teamInfo->thesis_title;

            $this->teamMembers = '';
            foreach ($teamInfo->members as $key => $member) {
                $this->teamMembers .= $key + 1 . '. ' . $member->name . "\n";
            }

            $this->panelists = '';
            foreach ($teamInfo->panelists as $key => $panelist) {
                $this->panelists .= $key + 1 . '. ' . $panelist->name . "\n";
            }
        } else {
            $this->clear();
        }
    }

    public function render()
    {
        if (auth()->user()->roles->pluck('name')[0] === 'student') {
            $userId = auth()->user()->id;
            $schedules = ScheduleModel::orderBy('start', 'desc')
                ->whereHas('team.members', function ($query) use ($userId) {
                    $query->where('id', $userId);
                })
                ->with('team', 'venue')
                ->paginate();
        } else {
            $schedules = ScheduleModel::orderBy('start', 'desc')
                ->with('team', 'venue')
                ->paginate();
        }

        $teams = Team::orderBy('name', 'asc')->with('schedule')->get();
        $venues = Venue::orderBy('name', 'asc')->get();
        return view('livewire.schedule', [
            'schedules' => $schedules,
            'teams' => $teams,
            'venues' => $venues,
        ]);
    }
}
