<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class CreateTeamAndTitle extends Component
{
    public string $name = '';
    public string $thesisTitle = '';
    public array $members = [];
    public array $panelists = [];
    public int $courseAndSection;
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
        dd($this->courseAndSection);
        $this->validate();
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
        $this->dispatch('showMembers');
    }

    public function render()
    {
        $courses = Course::orderBy('code', 'asc')->with('sections')->get();
        return view('livewire.create-team-and-title', [
            'courses' => $courses,
        ]);
    }
}
