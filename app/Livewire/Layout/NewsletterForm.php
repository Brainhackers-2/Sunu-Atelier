<?php

namespace App\Livewire\Layout;

use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewsletterForm extends Component
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    public bool $submitted = false;

    public function subscribe(): void
    {
        $this->validate();

        $cleanEmail = strtolower(trim($this->email));
        NewsletterSubscriber::firstOrCreate(
            ['email' => $cleanEmail],
            ['is_active' => true, 'created_at' => now()]
        );

        $this->submitted = true;
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.layout.newsletter-form');
    }
}
