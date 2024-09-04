<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Schedule;
use Livewire\Attributes\On;
use App\Livewire\TeamAndTitle;
use Illuminate\Support\Facades\DB;

class CreateTeamAndTitle extends Component
{
    public string $name = '';
    public string $thesisTitle = '';
    public array $members = [];
    public array $panelists = [];
    public $courseAndSection;
    public $capa;
    public $consultant;
    public $grammarian;
    public array $courseAndSectionUsers = [];

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

    public function store()
    {
        $this->validate();

        $team = Team::create([
            'user_id' => auth()->user()->id,
            'name' => $this->name,
            'thesis_title' => $this->thesisTitle,
            'capa_id' => $this->capa,
            'consultant_id' => $this->consultant,
            'grammarian_id' => $this->grammarian,
            'section_id' => $this->courseAndSection,
        ]);

        $team->members()->sync($this->members);
        $team->panelists()->sync($this->panelists);

        foreach ($team->panelists as $panelist) {
            $team->approvalStatus()->create([
                'user_id' => $panelist->id,
                'status' => Schedule::FOR_PANELIST_APPROVAL,
            ]);
        }

        session()->flash('success', 'Team created.');

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

    public function render()
    {
        $courses = Course::orderBy('code', 'asc')->with('sections')->get();
        $capas = User::role('capa')->get();
        $consultants = User::role('consultant')->get();
        $grammarians = User::role('grammarian')->get();
        $panelistUsers = User::role('panelist')->get();

        return view('livewire.create-team-and-title', [
            'courses' => $courses,
            'capas' => $capas,
            'consultants' => $consultants,
            'grammarians' => $grammarians,
            'panelistUsers' => $panelistUsers,
        ]);
    }
}
