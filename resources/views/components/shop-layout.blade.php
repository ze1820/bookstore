@props(['title' => null, 'description' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' | ' : '' }}Figs & Olives Publications</title>
    @if ($description)
        <meta name="description" content="{{ Str::limit(strip_tags($description), 155) }}">
    @endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-cream text-ink antialiased">

    <div class="bg-brand px-4 py-2 text-center text-xs font-medium text-white">
        7-day returns on sealed books &middot; Secure checkout
    </div>

    <header class="sticky top-0 z-20 border-b border-black/5 bg-cream/90 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2" aria-label="Figs & Olives home">
                @if (file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Figs & Olives Publications" class="h-10 w-auto">
                @else
                    <span class="font-display text-xl font-bold text-brand">Figs <span class="text-olive">&amp;</span> Olives</span>
                @endif
            </a>

            <nav class="hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="{{ route('shop.index') }}" class="transition hover:text-brand">Shop</a>
                <a href="{{ route('authors.index') }}" class="block py-3">Hijab Mentorship</a>
                <a href="{{ route('mentorship.show') }}" class="transition hover:text-brand">Meet the Authors</a>
<a href="{{ route('contact.show') }}" class="block py-3">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="transition hover:text-brand">My account</a>
                @else
                    <a href="{{ route('login') }}" class="transition hover:text-brand">Log in</a>
                @endauth
                <span class="cursor-not-allowed rounded-full bg-brand/10 px-4 py-2 text-brand" title="Coming soon">Cart</span>
            </nav>

            <button type="button" id="menu-toggle" aria-label="Open menu" aria-expanded="false"
                    class="rounded-lg p-2 hover:bg-black/5 md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>

        <nav id="mobile-menu" class="hidden border-t border-black/5 px-4 py-3 text-base font-medium md:hidden">
            <a href="{{ route('shop.index') }}" class="block py-3">Shop</a>
            <a href="{{ route('authors.index') }}" class="block py-3">Meet the Authors</a>
            <a href="{{ route('mentorship.show') }}" class="transition hover:text-brand">Hijab Mentorship</a>
<a href="{{ route('contact.show') }}" class="block py-3">Contact</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block py-3">My account</a>
            @else
                <a href="{{ route('login') }}" class="block py-3">Log in</a>
            @endauth
        </nav>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="mt-24 bg-ink text-white">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 md:grid-cols-3">
            <div class="md:col-span-2">
                <p class="font-display text-2xl font-bold">Figs &amp; Olives</p>
                <p class="mt-3 max-w-md text-sm leading-relaxed text-white/70">
                    A holistic approach to reading books, with an integration of virtual courses,
                    printable workbooks, and corresponding picture books.
                </p>
            </div>
            <div class="text-sm">
                <p class="font-semibold">Explore</p>

                <ul class="mt-3 space-y-2 text-white/70">
                    <li><a href="{{ route('shop.index') }}" class="transition hover:text-white">All books</a></li>
                    <li><a href="{{ route('authors.index') }}" class="transition hover:text-white">Meet the authors</a></li>
                    <a href="{{ route('mentorship.show') }}" class="transition hover:text-brand">Mentorship</a>
                    <li><a href="{{ route('contact.show') }}" class="transition hover:text-white">Contact</a></li>
                    <li><a href="{{ route('returns') }}" class="transition hover:text-white">Returns</a></li>
                    <li><a href="{{ route('mentorship.show') }}" class="transition hover:text-white">Hijab mentorship</a></li>
                    <li><a href="{{ route('volunteer.show') }}" class="transition hover:text-white">Volunteer</a></li>      
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs text-white/50">
            &copy; {{ date('Y') }} Figs &amp; Olives Publications. All rights reserved.
        </div>
    </footer>

    <script>
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        toggle.addEventListener('click', () => {
            const open = menu.classList.toggle('hidden') === false;
            toggle.setAttribute('aria-expanded', open);
        });
    </script>

    <script>
        // Auto-swapping image slideshows (book cards and product gallery)
        (() => {
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            document.querySelectorAll('[data-slideshow]').forEach((root) => {
                const slides = [...root.querySelectorAll('[data-slide]')];
                if (slides.length < 2) return;

                const marks = [...root.querySelectorAll('[data-dot], [data-go]')];
                const base = Number(root.dataset.interval) || 3500;
                const delay = base + Math.random() * 1200; // keeps cards from swapping in lockstep
                let index = 0, timer = null, visible = true;

                const show = (n) => {
                    index = (n + slides.length) % slides.length;
                    slides.forEach((s, k) => {
                        s.classList.toggle('opacity-100', k === index);
                        s.classList.toggle('opacity-0', k !== index);
                        s.setAttribute('aria-hidden', k === index ? 'false' : 'true');
                    });
                    marks.forEach((m, k) => m.setAttribute('aria-current', k === index ? 'true' : 'false'));
                };
                const stop = () => { clearInterval(timer); timer = null; };
                const start = () => { if (!reduce && visible && !timer) timer = setInterval(() => show(index + 1), delay); };
                const restart = () => { stop(); start(); };

                root.querySelectorAll('[data-go]').forEach((b) =>
                    b.addEventListener('click', () => { show(Number(b.dataset.go)); restart(); }));
                root.querySelector('[data-prev]')?.addEventListener('click', () => { show(index - 1); restart(); });
                root.querySelector('[data-next]')?.addEventListener('click', () => { show(index + 1); restart(); });

                if ('pauseOnHover' in root.dataset) {
                    root.addEventListener('mouseenter', stop);
                    root.addEventListener('mouseleave', start);
                    root.addEventListener('focusin', stop);
                    root.addEventListener('focusout', start);
                }

                // Only animate what is on screen
                new IntersectionObserver(([entry]) => {
                    visible = entry.isIntersecting;
                    visible ? start() : stop();
                }).observe(root);
            });

            // Tabs
            document.querySelectorAll('[data-tabs]').forEach((root) => {
                const tabs = [...root.querySelectorAll('[data-tab]')];
                const panels = [...root.querySelectorAll('[data-panel]')];
                const open = (name) => {
                    tabs.forEach((t) => t.setAttribute('aria-selected', t.dataset.tab === name ? 'true' : 'false'));
                    panels.forEach((p) => p.classList.toggle('hidden', p.dataset.panel !== name));
                };
                tabs.forEach((t) => t.addEventListener('click', () => open(t.dataset.tab)));
                document.querySelectorAll('[data-open-tab]').forEach((b) =>
                    b.addEventListener('click', () => { open(b.dataset.openTab); root.scrollIntoView({ behavior: 'smooth' }); }));
            });
        })();
    </script>
</body>
</html>