<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public const REASONS = [
        'General question',
        'Help with an order',
        'Bulk purchase',
        'Volunteering',
        'Other',
    ];

    public function show()
    {
        return view('contact', ['reasons' => self::REASONS]);
    }

    public function send(Request $request)
    {
        // Hidden field that real people never fill in. Bots usually do.
        if ($request->filled('website')) {
            return redirect()->route('contact.show')->with('sent', true);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:50'],
            'reason' => ['nullable', 'in:'.implode(',', self::REASONS)],
            'whatsapp_ok' => ['nullable', 'boolean'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        ContactMessage::create([
            ...$data,
            'whatsapp_ok' => $request->boolean('whatsapp_ok'),
        ]);

        return redirect()->route('contact.show')->with('sent', true);
    }
}