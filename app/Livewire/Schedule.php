<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use Livewire\Component;
use Livewire\WithPagination;
use App\Mail\ScheduleCreated;
use App\Models\ApprovalStatus;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Schedule as ScheduleModel;
use App\Mail\ReDefenseOrReScheduleCreated;

class Schedule extends Component
{
    use WithPagination;

    public int $id;
    public string $team = '';
    public string$thesisTitle = '';
    public string$teamMembers = '';
    public string$panelists = '';
    public array $panelistIds = [];
    public $venue;
    public $start;
    public $type;

    public $scheduleType = '';

    public $teams;

    public function mount()
    {
        $this->teams = Team::orderBy('name', 'asc')->with('schedule')->get();

        // dd($this->teams);
    }

    protected $rules = [
        'team' => 'required',
        'venue' => 'required',
        'start' => 'required|after_or_equal:now',
        'type' => 'required|integer',
    ];

    public function store()
    { 
        $this->validate();
       
        $isConflict = (new ScheduleService($this->team, $this->start, $this->panelistIds))
            ->checkScheduleConflict();
        
        if ($isConflict)
        {
            return $this->addError('team', "Unable to set the schedule due to a scheduling conflict with the team name '{$isConflict->team->name}'.");
        }

        $schedule = ScheduleModel::create([
            'user_id' => auth()->user()->id,
            'team_id' => $this->team,
            'venue_id' => $this->venue,
            'start' => $this->start,
            'end' => Carbon::parse($this->start)->addHours(2),
            'status' => ScheduleModel::FOR_PANELIST_APPROVAL,
            'type_of_defense' => $this->type,
        ]);

        //Notify all the panelist
        if(count($schedule->team->panelists) > 0)
        {
            foreach ($schedule->team->panelists as $panelist) {
                Mail::to($panelist->email)->queue(new ScheduleCreated($panelist, $schedule));
            }
        }

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
            if ($schedule->type_of_defense === $schedule::POD)
            {
                $schedule->type_of_defense = $schedule::FOD;
            }

            if ($schedule->type_of_defense === $schedule::TD)
            {
                $schedule->type_of_defense = $schedule::POD;
            }


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

    public function getTeamsByType()
    {
        $teams = Team::whereHas('schedule', function($q) {
            $q->whereHas('team', function($q) {
                $q->where('type_of_defense', $this->type);
            });
        })->get();

        $this->teams = $teams;
    }

    public function clear()
    {
        $this->team = '';
        $this->thesisTitle = '';
        $this->teamMembers = '';
        $this->panelists = '';
        $this->venue = '';
        $this->start = '';
        $this->panelistIds = [];
        $this->resetValidation();
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
                array_push($this->panelistIds, $panelist->id);
                $this->panelists .= $key + 1 . '. ' . $panelist->name . "\n";
            }
        } else {
            $this->clear();
        }
    }

    public function reScheduleOrReDefense()
    {
        $this->validate([
            'scheduleType' => 'required'
        ]);

        $isConflict = (new ScheduleService($this->team, $this->start, $this->panelistIds))
            ->checkScheduleConflictForStudent();
        
        if ($isConflict)
        {
            return $this->addError('team', "Unable to set the schedule due to a scheduling conflict with the team name '{$isConflict->team->name}'.");
        }

        $schedule = ScheduleModel::find($this->id);
        $schedule->custom_status = $this->scheduleType;
        $schedule->start = $this->start;
        $schedule->end = Carbon::parse($this->start)->addHours(2);
        $schedule->status = ScheduleModel::PENDING;
        $schedule->type_of_defense = $this->type;
        $schedule->save();

        ApprovalStatus::where('team_id', $schedule->team_id)->update(['status' => $schedule::FOR_PANELIST_APPROVAL]);

        //Email Admin
        $adminUsers = User::role('admin')->get();
        foreach ($adminUsers as $adminUser) {
            Mail::to($adminUser->email)->queue(new ReDefenseOrReScheduleCreated($schedule));
        }

        session()->flash('success', 'Submitted for approval');

        $this->redirect(Schedule::class);

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

        $venues = Venue::orderBy('name', 'asc')->get();
        return view('livewire.schedule', [
            'schedules' => $schedules,
            'venues' => $venues,
        ]);
    }
}
