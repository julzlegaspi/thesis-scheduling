<?php

namespace App\Livewire;

use Livewire\Component;

class OnQueue extends Component
{
    public function render()
    {
        return view('livewire.on-queue')->layout('layouts.queue');
    }
}
