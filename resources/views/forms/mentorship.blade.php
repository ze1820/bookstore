<x-shop-layout title="Hijab mentorship" description="One-on-one hijab mentorship for women who want guidance and support.">
    <div class="mx-auto max-w-3xl px-4 py-12">
        <p class="text-sm font-semibold uppercase tracking-widest text-olive">Mentorship program</p>
        <h1 class="mt-2 text-4xl font-bold">Welcome to our hijab mentorship program</h1>

        <div class="mt-6 space-y-4 leading-relaxed text-ink/80">
            <p>
                Your questions and emotions are valid, and we are here to help. The program offers
                guidance and support for women who are interested in wearing the hijab, or who are
                in the early stages of their hijab journey.
            </p>
            <p>
                It includes five 60-minute sessions with a mentor, either Sahar Jaber in English or
                Haniya Salameh in Arabic. Topics include theology, Islamic scripture, and Islamic
                jurisprudence. Seats are limited each month, and financial assistance is available.
            </p>
        </div>

        <h2 class="mt-12 text-2xl font-bold">Apply now</h2>

        @if (session('sent'))
            <div class="mt-4 rounded-2xl bg-olive/10 px-5 py-4 text-sm font-medium text-olive ring-1 ring-olive/20" role="status">
                Thank you. We received your application and will be in touch by email.
            </div>
        @endif

        <form method="POST" action="{{ route('mentorship.send') }}"
              class="mt-6 space-y-5 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5 md:p-8">
            @csrf
            <div class="hidden" aria-hidden="true">
                <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <x-field name="name" label="Name" required />
                <x-field name="age" label="Age" type="number" required />
                <x-field name="country" label="Country of residence" required />
                <x-field name="occupation" label="Occupation or student" :options="$occupations" required />
                <x-field name="academic_level" label="Level of academic knowledge" required />
                <x-field name="email" label="Email address" type="email" required />
                <x-field name="phone" label="Phone" required />
                <x-field name="wears_hijab" label="Do you currently wear the hijab?" :options="$hijab" required />
            </div>

            <x-field name="relationship" label="Tell us about your current relationship with the hijab" type="textarea" :rows="5" required />

            <div class="grid gap-5 md:grid-cols-2">
                <x-field name="financial_assistance" label="Do you require financial assistance?" :options="$financial" required />
                <x-field name="preferred_dates" label="When would you like to sign up? Dates and days that work" required />
            </div>

            <button class="rounded-full bg-brand px-8 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-brand-dark">
                Submit application
            </button>
        </form>
    </div>
</x-shop-layout>