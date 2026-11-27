<x-shop-layout title="Hijab mentorship" description="One-on-one hijab mentorship for women who want guidance, support, and an honest conversation. Five 60-minute sessions with an experienced mentor.">

    {{-- Hero --}}
    <section class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-14 md:grid-cols-2 md:py-20">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-olive">Hijab mentorship program</p>
            <h1 class="mt-4 text-4xl font-bold leading-[1.1] md:text-5xl">
                Your questions are valid. <span class="text-brand">We are here to help.</span>
            </h1>
            <p class="mt-6 max-w-lg text-lg leading-relaxed text-ink/70">
                One-on-one mentorship for women who are curious about the hijab, new to wearing it,
                or finding it hard to keep it on.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#apply"
                   class="rounded-full bg-brand px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand/30 transition hover:-translate-y-0.5 hover:bg-brand-dark">
                    Apply now
                </a>
                <a href="#how"
                   class="rounded-full px-7 py-3.5 text-sm font-semibold text-brand ring-1 ring-brand/30 transition hover:bg-brand-50">
                    How it works
                </a>
            </div>
        </div>

        {{-- Video: loads only after a click --}}
        <div>
            <div id="video" class="relative aspect-video overflow-hidden rounded-3xl bg-ink shadow-xl ring-1 ring-black/5">
                <button type="button" id="video-play" aria-label="Play the mentorship program video"
                        class="group absolute inset-0 h-full w-full">
                    <img src="https://i.ytimg.com/vi/vngJhNg3nXA/hqdefault.jpg" alt="" loading="lazy"
                         class="h-full w-full object-cover opacity-90 transition group-hover:opacity-100">
                    <span class="absolute inset-0 flex items-center justify-center">
                        <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white/95 text-brand shadow-lg transition group-hover:scale-110">
                            <svg class="ml-1 h-7 w-7" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                    </span>
                </button>
            </div>
            <p class="mt-3 text-center text-xs text-ink/50">Watch a short introduction (about 2 minutes)</p>
        </div>
    </section>

    {{-- Is this for you? --}}
    <section class="mx-auto max-w-6xl px-4">
        <div class="rounded-3xl bg-brand-50 px-6 py-12 md:px-14">
            <h2 class="text-center text-3xl font-bold">Is this for you?</h2>
            <div class="mx-auto mt-8 grid max-w-3xl gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <p class="font-semibold">Are you new to wearing hijab and looking for guidance and support?</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <p class="font-semibold">Are you struggling to keep the hijab on, or do not understand why you have to wear it?</p>
                </div>
            </div>
            <p class="mx-auto mt-8 max-w-2xl text-center leading-relaxed text-ink/70">
                The program is for women who are interested in wearing the hijab, or who are in the
                early stages of their hijab journey. The decision to wear it is shaped by social and
                spiritual values, and it can come with its own questions. That is where we come in.
            </p>
        </div>
    </section>

    {{-- What it includes --}}
    <section class="mx-auto mt-20 max-w-6xl px-4">
        <h2 class="text-center text-3xl font-bold">What the program includes</h2>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ([
                ['Five 60-minute sessions', 'Personal time with a mentor to talk through your questions at your own pace.', 'M12 6v6l4 2M12 21a9 9 0 100-18 9 9 0 000 18z'],
                ['English or Arabic', 'Sessions with Sahar Jaber in English, or with Haniya Salameh in Arabic.', 'M3 12h18M12 3a14 14 0 010 18M12 3a14 14 0 000 18M12 21a9 9 0 100-18 9 9 0 000 18z'],
                ['Topics that matter', 'Theology, Islamic scripture, Islamic jurisprudence, and practical ways to begin or improve your hijab.', 'M4 6h16M4 12h16M4 18h10'],
            ] as [$head, $text, $icon])
                <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-black/5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-brand">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                    </div>
                    <h3 class="mt-5 text-xl font-bold">{{ $head }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink/70">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- How it works --}}
    <section id="how" class="mx-auto mt-20 max-w-6xl scroll-mt-24 px-4">
        <h2 class="text-center text-3xl font-bold">How it works</h2>
        <ol class="mt-10 grid gap-8 md:grid-cols-4">
            @foreach ([
                ['Apply', 'Fill in the short form below. It takes a few minutes.'],
                ['We review', 'If the program fits, we email you the next steps.'],
                ['Book your sessions', 'Seats are limited each month, so booking early secures your spot.'],
                ['Begin your journey', 'Meet your mentor and bring every question you have.'],
            ] as $i => [$head, $text])
                <li class="text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-brand font-display text-lg font-bold text-white">{{ $i + 1 }}</div>
                    <h3 class="mt-4 font-semibold">{{ $head }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink/70">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Pull quote --}}
    <section class="mx-auto mt-20 max-w-4xl px-4 text-center">
        <p class="font-display text-2xl font-semibold leading-snug text-ink md:text-3xl">
            When we only understand the hijab from a social and cultural perspective, we lose sight
            of its religious and spiritual essence. How do we resolve this? By having difficult conversations.
        </p>
    </section>

    {{-- FAQ --}}
    <section class="mx-auto mt-20 max-w-3xl px-4">
        <h2 class="text-center text-3xl font-bold">Common questions</h2>
        <div class="mt-8 divide-y divide-black/10 rounded-3xl bg-white px-6 shadow-sm ring-1 ring-black/5">
            @foreach ([
                ['Who can apply?', 'Women who are interested in wearing the hijab, or who are in the early stages of their hijab journey.'],
                ['How long is the program?', 'Five 60-minute sessions with a mentor.'],
                ['Which languages are available?', 'English with Sahar Jaber, or Arabic with Haniya Salameh.'],
                ['Is it paid?', 'Yes, it is a paid program, and the details are included in the email we send after you apply. Financial assistance is available, because finance should never be a reason to stop learning about the hijab.'],
                ['How many seats are there?', 'We offer a limited number of seats each month, so we recommend booking your sessions in advance.'],
                ['What happens after I apply?', 'We review your application. If the program is a good fit, we email you the next steps for registration.'],
            ] as [$question, $answer])
                <details class="group py-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold">
                        {{ $question }}
                        <span class="text-brand transition group-open:rotate-45" aria-hidden="true">+</span>
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-ink/70">{{ $answer }}</p>
                </details>
            @endforeach
        </div>
    </section>

    {{-- Application form --}}
    <section id="apply" class="mx-auto mt-20 max-w-3xl scroll-mt-24 px-4">
        <h2 class="text-center text-3xl font-bold">We are excited to begin this journey with you</h2>
        <p class="mt-3 text-center text-ink/70">Apply below and we will be in touch by email.</p>

        @if (session('sent'))
            <div class="mt-6 rounded-2xl bg-olive/10 px-5 py-4 text-sm font-medium text-olive ring-1 ring-olive/20" role="status">
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

            <p class="text-xs text-ink/50">
                We use these details only to review your application and contact you.
            </p>

            <button class="w-full rounded-full bg-brand px-8 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-brand-dark sm:w-auto">
                Submit application
            </button>
        </form>
    </section>

    <script>
        document.getElementById('video-play')?.addEventListener('click', function () {
            const box = document.getElementById('video');
            box.innerHTML =
                '<iframe class="absolute inset-0 h-full w-full" ' +
                'src="https://www.youtube-nocookie.com/embed/vngJhNg3nXA?autoplay=1&rel=0" ' +
                'title="Hijab Mentorship program" allow="autoplay; encrypted-media; picture-in-picture" ' +
                'allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>';
        });
    </script>
</x-shop-layout>