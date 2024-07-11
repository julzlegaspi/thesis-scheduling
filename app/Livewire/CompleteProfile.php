<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Livewire\Component;

class CompleteProfile extends Component
{
    public $course = '';
    public $section = '';

    public function mount()
    {
        $this->course = auth()->user()->course_id;
        $this->section = auth()->user()->section_id;
    }

    protected $rules = [
        'course' => 'required',
        'section' => 'required'
    ];

    public function store()
    {
        $this->validate();
        
        $user = User::find(auth()->user()->id);

        $user->course_id = $this->course;
        $user->section_id = $this->section;
        $user->save();

        session()->flash('success', 'Profile completed');

        $this->redirect(Dashboard::class);
    }

    public function render()
    {
        $courses = Course::orderBy('name', 'asc')->get();
        $sections = Section::orderBy('name', 'asc')->get();
        return view('livewire.complete-profile', [
            'courses' => $courses,
            'sections' => $sections,
        ]);
    }
}
