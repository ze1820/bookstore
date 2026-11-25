<x-shop-layout title="Volunteer" description="Join the Figs & Olives volunteer club.">
    <div class="mx-auto max-w-3xl px-4 py-12">
        <p class="text-sm font-semibold uppercase tracking-widest text-olive">Volunteer club</p>
        <h1 class="mt-2 text-4xl font-bold">Would you like to join?</h1>
        <p class="mt-4 leading-relaxed text-ink/80">
            Doors are open for volunteering opportunities. Tell us where you would like to help.
        </p>

        @if (session('sent'))
            <div class="mt-8 rounded-2xl bg-olive/10 px-5 py-4 text-sm font-medium text-olive ring-1 ring-olive/20" role="status">
                Thank you for offering your time. We will get back to you soon.
            </div>
        @endif

        <form method="POST" action="{{ route('volunteer.send') }}"
              class="mt-8 space-y-5 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5 md:p-8">
            @csrf
            <div class="hidden" aria-hidden="true">
                <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <x-field name="name" label="Name" required />
                <x-field name="email" label="Email address" type="email" required />
                <x-field name="phone" label="WhatsApp phone number" required />
                <x-field name="age" label="Age" type="number" required />
                <x-field name="city" label="City of residence" required />
                <x-field name="country" label="Country of residence" required />
            </div>

            <fieldset>
                <legend class="text-sm font-medium">What positions are you interested in? *</legend>
                <div class="mt-2 grid gap-2 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($positions as $position)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="positions[]" value="{{ $position }}"
                                   @checked(in_array($position, old('positions', []))) class="rounded text-brand focus:ring-brand">
                            {{ $position }}
                        </label>
                    @endforeach
                </div>
                @error('positions') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <div class="grid gap-5 md:grid-cols-2">
                <x-field name="hours_per_week" label="Hours per week you can volunteer" :options="$hours" required />
                <x-field name="experience" label="Years of experience in the position (optional)" />
            </div>

            <x-field name="why" label="Why do you want to volunteer with Figs & Olives?" type="textarea" :rows="4" required />
            <x-field name="hope" label="What do you hope to get out of this experience?" type="textarea" :rows="4" required />

            <button class="rounded-full bg-brand px-8 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-brand-dark">
                Submit
            </button>
        </form>
    </div>
</x-shop-layout>