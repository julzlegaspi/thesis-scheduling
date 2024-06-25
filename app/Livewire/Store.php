<?php

namespace App\Livewire;

use App\Models\Store as StoreModel;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Store extends Component
{
    public $id;

    #[Validate('required|string|max:50')]
    public $name;

    #[Validate('required|string|max:100')]
    public $address;

    public function store()
    {
        $this->validate();

        try {
            StoreModel::firstOrCreate(
                [
                    'user_id' => auth()->user()->id,
                    'name' => $this->name
                ],
                [
                    'user_id' => auth()->user()->id,
                    'name' => $this->name,
                    'address' => $this->address
                ]
            );

            session()->flash('success', 'Store created.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong. Please try again.');
        }

        $this->redirect(Store::class);
    }

    public function edit($id)
    {
        $store = auth()->user()->stores()->where('id', $id)->first();
        $this->id = $store->id;
        $this->name = $store->name;
        $this->address = $store->address;
    }

    public function update()
    {
        $this->validate();

        try {
            $store = auth()->user()->stores()->where('id', $this->id)->update([
                'name' => $this->name,
                'address' => $this->address
            ]);

            $this->clear();

            session()->flash('success', 'Store updated.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong. Please try again.');
        }

        $this->redirect(Store::class);
    }

    public function destroy($id)
    {
        try {
            auth()->user()->stores()->where('id', $id)->delete();

            session()->flash('success', 'Store deleted.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong. Please try again.');
        }

        $this->redirect(Store::class);
    }

    public function clear()
    {
        $this->id = '';
        $this->name = '';
        $this->address = '';
        $this->resetValidation();
    }

    public function render()
    {
        $stores = auth()->user()->stores;
        return view('livewire.store', [
            'stores' => $stores
        ]);
    }
}
