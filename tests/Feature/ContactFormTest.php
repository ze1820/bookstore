<?php

use App\Livewire\ContactForm;
use App\Models\FormSubmission;
use Livewire\Livewire;

it('saves a valid contact message', function () {
    Livewire::test(ContactForm::class, ['type' => 'contact'])
        ->set('name', 'Sara')
        ->set('email', 'sara@example.com')
        ->set('message', 'Do you offer bulk discounts?')
        ->call('submit')
        ->assertSet('sent', true);

    expect(FormSubmission::count())->toBe(1);
});

it('ignores honeypot submissions', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'Bot')
        ->set('email', 'bot@example.com')
        ->set('message', 'spam')
        ->set('website', 'http://spam.test')
        ->call('submit');

    expect(FormSubmission::count())->toBe(0);
});