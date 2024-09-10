<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Schedule;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class EditTeamAndTitle extends Component
{
    public Team $team;
    public $id;
    public string $name = '';
    public string $thesisTitle = '';
    public array $members = [];
    public array $panelists = [];
    public $courseAndSection;
    public $capa;
    public $consultant;
    public $grammarian;
    public array $courseAndSectionUsers = [];
    
    public function mount(Team $team)
    {
        $this->team = $team;
        $this->id = $team->id;
        $this->name = $team->name;
        $this->thesisTitle = $team->thesis_title;
        $this->courseAndSection = $team->section_id;

        
        foreach ($team->members as $member) {
            array_push($this->members, $member->id);
        }
        
        $memberUsers = User::role('student')->where('section_id', $this->courseAndSection)->get();
        foreach ($memberUsers as $member) {
            array_push($this->courseAndSectionUsers, [
                'id' => $member->id,
                'name' => $member->name
            ]);
        }

        $panelists = $team->panelists->sortByDesc('is_panel_chair');

        foreach ($panelists as $panelist) {
            array_push($this->panelists, $panelist->id);
        }

        $this->capa = $team->capa_id;
        $this->consultant = $team->consultant_id;
        $this->grammarian = $team->grammarian_id;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'thesisTitle' => 'required|string|max:255',
        'courseAndSection' => 'sometimes|required',
        'members.*' => 'sometimes|required|distinct',
        'panelists.*' => 'sometimes|required|distinct',
    ];

    protected $messages = [
        'members.*.required' => 'The member field is required.',
        'members.*.distinct' => 'The selected member is already selected.',
        'panelists.*.required' => 'The panelist field is required.',
        'panelists.*.distinct' => 'The selected panelist is already selected.',
    ];

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
        $this->team->capa_id = $this->capa ?? null;
        $this->team->consultant_id = $this->consultant ?? null;
        $this->team->grammarian_id = $this->grammarian ?? null;
        $this->team->section_id = $this->courseAndSection;
        $this->team->save();
        
        $this->team->members()->sync($this->members);
        $this->team->panelists()->sync($this->panelists);

        foreach ($this->panelists as $panelist) {
            if (!$this->team->approvalStatus()->where('user_id', $panelist)->first())
            {
                $this->team->approvalStatus()->create([
                    'user_id' => $panelist,
                    'status' => Schedule::FOR_PANELIST_APPROVAL
                ]);
            }
        }

        session()->flash('success', 'Team updated.');

        $this->redirect(TeamAndTitle::class);
    }

    #[On('course-change')]
    public function getMembers()
    {
        //get users based on course and section id
        $users = User::role('student')->where('section_id', $this->courseAndSection)->get();
        $this->courseAndSectionUsers = [];
        foreach ($users as $user) {
            $inMember = DB::table('member_team')->where('user_id', $user->id)->first();

            if (!$inMember)
            {
                $this->courseAndSectionUsers[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                ];
            }
        }
        
    }

    public function destroy(Team $team)
    {
        $team->delete();

        $team->schedule()->delete();

        session()->flash('success', 'Team deleted.');

        return $this->redirect(TeamAndTitle::class);
    }

    public function render()
    {
        $courses = Course::orderBy('code', 'asc')->with('sections')->get();
        $capasAndConsultants = User::role(['capa', 'consultant'])->get();
        $grammarians = User::role('grammarian')->get();
        $panelistUsers = User::role('panelist')->get();

        return view('livewire.edit-team-and-title', [
            'courses' => $courses,
            'capasAndConsultants' => $capasAndConsultants,
            'grammarians' => $grammarians,
            'panelistUsers' => $panelistUsers,
        ]);
    }
}
