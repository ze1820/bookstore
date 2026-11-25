<?php

namespace App\Livewire;

use App\Models\FormSubmission;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $type = 'contact';
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public string $website = '';
    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:190'],
            'phone'   => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:3000'],
        ];
    }

    public function submit(): void
    {
        $key = 'form:' . $this->type . ':' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('message', 'Too many attempts. Please try again later.');
            return;
        }
        RateLimiter::hit($key, 3600);

        $data = $this->validate();

        if ($this->website !== '') {
            $this->sent = true;
            return;
        }

        FormSubmission::create($data + ['type' => $this->type]);

        $this->reset(['name', 'email', 'phone', 'message']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
