<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;

class CourseDetail extends Component
{
    public int $courseId;

    public Course $course;

    public string $courseCode = '';

    public string $courseName = '';

    public $sectionId;

    public string $sectionName = '';

    public function mount(Course $course)
    {
        $this->authorize('admin.read');

        $course->with('section');
        $this->courseId = $course->id;
        $this->courseCode = $course->code;
        $this->courseName = $course->name;
    }

    protected $rules = [
        'courseCode' => 'required|string',
        'courseName' => 'required|string'
    ];

    public function updateCourse()
    {
        $this->validate();

        $course = Course::find($this->courseId);

        $course->code = $this->courseCode;
        $course->name = $this->courseName;
        $course->save();

        session()->flash('success', 'Course updated.');
        
        return redirect()->route('courses.index');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();

        session()->flash('success', 'Course deleted.');

        return redirect()->route('courses.index');
    }

    public function addSection()
    {
        $validated = $this->validate([
            'sectionName' => 'required|string'
        ]);

        $this->course->sections()->create(['name' => $validated['sectionName']]);

        session()->flash('success', 'Section created.');

        return redirect()->route('course.show', ['course' => $this->courseId]);
    }

    public function editSection(Section $section)
    {
        $this->sectionId = $section->id;
        $this->sectionName = $section->name;
    }

    public function updateSection()
    {
        $validated = $this->validate(['sectionName' => 'required|string']);

        $this->course->sections()->where('id', $this->sectionId)->update(['name' => $validated['sectionName']]);

        session()->flash('success', 'Section updated.');

        return redirect()->route('course.show', ['course' => $this->courseId]);
    }

    public function destroySection(Section $section)
    {
        $section->delete();

        session()->flash('success', 'Section deleted.');

        return redirect()->route('course.show', ['course' => $this->courseId]);
    }

    public function clear()
    {
        $this->sectionId = null;
        $this->sectionName = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.course-detail');
    }
}
