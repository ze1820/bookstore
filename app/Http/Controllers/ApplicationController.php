<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public const OCCUPATIONS = ['Student', 'Working', 'Student and working', 'Other'];
    public const HIJAB = ['Yes, always', 'Sometimes', 'Not yet', 'I am considering it'];
    public const FINANCIAL = ['Yes', 'No', 'I would like to discuss it'];
    public const POSITIONS = [
        'Advertiser', 'Animation', 'Audio enhancer', 'Content creator', 'Creative input',
        'Graphic designer', 'Marketing', 'Outreach', 'Photography', 'Researcher',
        'Social media', 'Translator', 'Video editor', 'Website upkeeping',
    ];
    public const HOURS = ['1 to 2 hours', '3 to 5 hours', '6 to 10 hours', 'More than 10 hours'];

    public function mentorship()
    {
        return view('forms.mentorship', [
            'occupations' => self::OCCUPATIONS,
            'hijab' => self::HIJAB,
            'financial' => self::FINANCIAL,
        ]);
    }

    public function sendMentorship(Request $request)
    {
        if ($request->filled('website')) {
            return redirect()->route('mentorship.show')->with('sent', true);
        }

        $v = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'country' => ['required', 'string', 'max:100'],
            'occupation' => ['required', Rule::in(self::OCCUPATIONS)],
            'academic_level' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:50'],
            'wears_hijab' => ['required', Rule::in(self::HIJAB)],
            'relationship' => ['required', 'string', 'min:10', 'max:5000'],
            'financial_assistance' => ['required', Rule::in(self::FINANCIAL)],
            'preferred_dates' => ['required', 'string', 'max:500'],
        ]);

        FormSubmission::create([
            'type' => 'mentorship',
            'name' => $v['name'],
            'email' => $v['email'],
            'phone' => $v['phone'],
            'message' => $v['relationship'],
            'data' => collect($v)->except(['name', 'email', 'phone', 'relationship'])->all(),
        ]);

        return redirect()->route('mentorship.show')->with('sent', true);
    }

    public function volunteer()
    {
        return view('forms.volunteer', [
            'positions' => self::POSITIONS,
            'hours' => self::HOURS,
        ]);
    }

    public function sendVolunteer(Request $request)
    {
        if ($request->filled('website')) {
            return redirect()->route('volunteer.show')->with('sent', true);
        }

        $v = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:50'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'city' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'positions' => ['required', 'array', 'min:1'],
            'positions.*' => [Rule::in(self::POSITIONS)],
            'experience' => ['nullable', 'string', 'max:2000'],
            'hours_per_week' => ['required', Rule::in(self::HOURS)],
            'why' => ['required', 'string', 'min:10', 'max:5000'],
            'hope' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        FormSubmission::create([
            'type' => 'volunteer',
            'name' => $v['name'],
            'email' => $v['email'],
            'phone' => $v['phone'],
            'message' => $v['why'],
            'data' => collect($v)->except(['name', 'email', 'phone', 'why'])->all(),
        ]);

        return redirect()->route('volunteer.show')->with('sent', true);
    }
}