<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\Section as SectionModel;

class Section extends Component
{
    use WithPagination;

    public SectionModel $section;

    public $id;
    
    #[Rule('required|string')]
    public $name = '';

    public function mount()
    {
        $this->authorize('admin.read');
    }

    public function store()
    {
        $this->validate();

        SectionModel::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Section created.');
        $this->redirect(Section::class);
    }

    public function edit(SectionModel $section)
    {
        $this->id = $section->id;
        $this->section = $section;
        $this->name = $section->name;
    }

    public function update()
    {
        $this->validate();

        $this->section->name = $this->name;
        $this->section->save();

        session()->flash('success', 'Section updated.');

        $this->redirect(Section::class);
    }

    public function destroy(SectionModel $section)
    {
        $section->delete();

        session()->flash('success', 'Section deleted.');

        $this->redirect(Section::class);
    }

    public function clear()
    {
        $this->name = '';
        $this->resetValidation();
    }

    public function render()
    {
        $sections = SectionModel::orderBy('name', 'asc')->paginate();

        return view('livewire.section', [
            'sections' => $sections
        ]);
    }
}
