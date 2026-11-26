<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Livewire\Attributes\Validate;

class NewsletterForm extends Component
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    public bool $submitted = false;
    public bool $alreadySubscribed = false;

    public function subscribe(): void
    {
        $this->validate();
        // Sera enrichi Phase 4 avec le modèle NewsletterSubscriber
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.layout.newsletter-form');
    }
}
