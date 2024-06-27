<?php

namespace App\Livewire;

use App\Models\Team;
use Livewire\Component;

class TeamAndTitle extends Component
{
    public $id;
    public $name;
    public $thesisName;
    

    public function mount()
    {
        $this->authorize('student.read');
    }

    public function store()
    {
        
    }

    public function edit($id)
    {

    }

    public function update()
    {

    }

    public function destroy($id)
    {

    }

    public function clear()
    {

    }

    public function render()
    {
        $teams = Team::where('user_id', auth()->user()->id)->with('users')->get();

        return view('livewire.team-and-title', [
            'teams' => $teams
        ]);
    }
}
