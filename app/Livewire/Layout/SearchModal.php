<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class SearchModal extends Component
{
    public string $query = '';

    public function render()
    {
        return view('livewire.layout.search-modal');
    }
}
