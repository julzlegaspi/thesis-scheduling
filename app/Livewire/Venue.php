<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\Venue as VenueModel;
use Illuminate\Database\QueryException;

class Venue extends Component
{
    use WithPagination;

    public VenueModel $venue;

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

        VenueModel::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Venue created.');
        $this->redirect(Venue::class);
    }

    public function edit(VenueModel $venue)
    {
        $this->id = $venue->id;
        $this->venue = $venue;
        $this->name = $venue->name;
    }

    public function update()
    {
        $this->validate();

        $this->venue->name = $this->name;
        $this->venue->save();

        session()->flash('success', 'Venue updated.');

        $this->redirect(Venue::class);
    }

    public function destroy(VenueModel $venue)
    {
        if ($venue->schedules()->count() > 0) {
            return $this->addError('name', 'Cannot delete venue that have scheduled.');
        }
        
        $venue->delete();

        session()->flash('success', 'Venue deleted.');

        $this->redirect(Venue::class);
    }

    public function clear()
    {
        $this->name = '';
        $this->resetValidation();
    }
    
    public function render()
    {
        $venues = VenueModel::orderBy('name', 'asc')->paginate();

        return view('livewire.venue', [
            'venues' => $venues,
        ]);
    }
}
