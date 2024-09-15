<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;

class CompleteProfile extends Component
{
    public $courseAndSection = '';

    public function mount()
    {
        $courseId = auth()->user()->course_id;
        $sectionId = auth()->user()->section_id;
        if ($courseId != null || $sectionId != null)
        {
            $this->courseAndSection = "{$courseId},{$sectionId}";
        } else {
            $this->courseAndSection = '';
        }
    }

    protected $rules = [
        'courseAndSection' => 'required',
    ];

    public function store()
    {
        $this->validate();

        $exploded = explode(',', $this->courseAndSection);
        
        $user = User::find(auth()->user()->id);

        $user->course_id = $exploded[0];
        $user->section_id = $exploded[1];
        $user->save();

        session()->flash('success', 'Profile completed');

        $this->redirect(Dashboard::class);
    }

    public function render()
    {
        $courses = Course::orderBy('name', 'asc')
            ->with('sections')
            ->get();
        return view('livewire.complete-profile', [
            'courses' => $courses,
        ]);
    }
}
