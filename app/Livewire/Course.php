<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\Course as CourseModel;

class Course extends Component
{
    use WithPagination;

    public CourseModel $course;

    #[Rule('required|string')]
    public $code = '';

    #[Rule('required|string')]
    public $name = '';

    public function store()
    {
        $this->validate();

        CourseModel::create([
            'code' => $this->code,
            'name' => $this->name
        ]);

        session()->flash('success', 'Course created.');
        $this->redirect(Course::class);
    }

    public function edit(CourseModel $course)
    {
        $this->course = $course;
        $this->code = $course->code;
        $this->name = $course->name;
    }

    public function update()
    {
        $this->validate();

        $this->course->code = $this->code;
        $this->course->name = $this->name;
        $this->course->save();

        session()->flash('success', 'Course updated.');

        $this->redirect(Course::class);
    }

    public function destroy(CourseModel $course)
    {
        $course->delete();

        session()->flash('success', 'Course deleted.');

        $this->redirect(Course::class);
    }

    public function clear()
    {
        $this->code = '';
        $this->name = '';
    }

    public function render()
    {
        $courses = CourseModel::orderBy('code', 'asc')->paginate();

        return view('livewire.course', [
            'courses' => $courses
        ]);
    }
}
