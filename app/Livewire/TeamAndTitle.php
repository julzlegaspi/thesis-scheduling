<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\ApprovalStatus;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class TeamAndTitle extends Component
{
    public Team $team;
    public $id;
    public $name = '';
    public $thesisTitle = '';
    public $members = [];
    public $panelists = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'thesisTitle' => 'required|string|max:255',
        'members.*' => 'sometimes|required|distinct',
        'panelists.*' => 'sometimes|required|distinct',
    ];

    protected $messages = [
        'members.*.required' => 'The member field is required.',
        'members.*.distinct' => 'The selected member is already selected.',
        'panelists.*.required' => 'The panelist field is required.',
        'panelists.*.distinct' => 'The selected panelist is already selected.',
    ];

    public function store()
    {
        $this->validate();

        $team = Team::create([
            'user_id' => auth()->user()->id,
            'name' => $this->name,
            'thesis_title' => $this->thesisTitle,
        ]);

        $team->members()->sync($this->members);
        $team->panelists()->sync($this->panelists);

        foreach ($team->panelists as $panelist) {
            $team->approvalStatus()->create([
                'user_id' => $panelist->id,
                'status' => Schedule::PENDING,
            ]);
        }

        session()->flash('success', 'Team created.');

        $this->redirect(TeamAndTitle::class);
    }

    public function edit(Team $team)
    {
        $this->clear();
        $this->team = $team;
        $this->id = $team->id;
        $this->name = $team->name;
        $this->thesisTitle = $team->thesis_title;

        foreach ($team->members as $member) {
            array_push($this->members, $member->id);
        }

        foreach ($team->panelists as $panelist) {
            array_push($this->panelists, $panelist->id);
        }
    }

    public function update()
    {
        $this->validate();

        foreach ($this->team->panelists as $panelist) {
            if(!in_array($panelist->id, $this->panelists))
            {
                $this->team->approvalStatus()->where('user_id', $panelist->id)->delete();
            } 
        }

        $this->team->name = $this->name;
        $this->team->thesis_title = $this->thesisTitle;
        $this->team->save();

        $this->team->members()->sync($this->members);
        $this->team->panelists()->sync($this->panelists);

        foreach ($this->panelists as $panelist) {
            if (!$this->team->approvalStatus()->where('user_id', $panelist)->first())
            {
                $this->team->approvalStatus()->create([
                    'user_id' => $panelist,
                    'status' => Schedule::PENDING
                ]);
            }
        }

        session()->flash('success', 'Team updated.');

        $this->redirect(TeamAndTitle::class);
    }

    public function destroy(Team $team)
    {
        $team->delete();

        session()->flash('success', 'Team deleted.');

        $this->redirect(TeamAndTitle::class);
    }

    public function clear()
    {
        $this->id = null;
        $this->name = '';
        $this->thesisTitle = '';
        $this->members = [];
        $this->panelists = [];
        $this->resetValidation();
    }

    public function addMember()
    {
        array_push($this->members, '');
    }

    public function removeMember($key)
    {
        unset($this->members[$key]);
        array_values($this->members);
    }

    public function addPanelist()
    {
        array_push($this->panelists, [
            'id' => '',
        ]);
    }

    public function removePanelist($key)
    {
        unset($this->panelists[$key]);
        array_values($this->panelists);
    }

    public function render()
    {
        $panelistUsers = User::role('panelist')->get();

        if (auth()->user()->roles->pluck('name')[0] === 'admin') {
            $teams = Team::with('user', 'members', 'panelists')->paginate();
            $studentUsers = User::role('student')
                ->where('id', '!=', auth()->user()->id)
                ->with('course', 'section')
                ->get()
                ->groupBy(function ($item) {
                    return $item->course->name;
                });
        }

        if (auth()->user()->roles->pluck('name')[0] === 'student') {

            $studentUsers = User::role('student')
                ->where('course_id', auth()->user()->course_id)
                ->where('section_id', auth()->user()->course_id)
                ->with('course', 'section')
                ->get()
                ->groupBy(function ($item) {
                    return $item->course->name;
                });

            // Get all teams created by the current user
            $createdTeams = Team::where('user_id', auth()->user()->id)
                ->with('user', 'members', 'panelists')
                ->get();

            // Get all teams the current user belongs to
            $belongingTeams = auth()->user()->teams()->with('user', 'members', 'panelists')->get();

            // Merge the results
            $allTeams = $createdTeams->merge($belongingTeams);

            // Remove duplicates
            $uniqueTeams = $allTeams->unique('id')->values();

            // Paginate the results
            $currentPage = Paginator::resolveCurrentPage();
            $perPage = 10;
            $currentPageItems = $uniqueTeams->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $teams = new LengthAwarePaginator($currentPageItems, $uniqueTeams->count(), $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath(),
            ]);
        }

        return view('livewire.team-and-title', [
            'teams' => $teams,
            'studentUsers' => $studentUsers,
            'panelistUsers' => $panelistUsers,
        ]);
    }
}
