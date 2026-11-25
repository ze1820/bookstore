<x-shop-layout title="Meet the Authors" description="The authors behind Figs & Olives Publications.">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <p class="text-sm font-semibold uppercase tracking-widest text-olive">Our team</p>
        <h1 class="mt-2 text-4xl font-bold">Meet the Authors</h1>

        <div class="mt-10 grid grid-cols-2 gap-x-5 gap-y-10 md:grid-cols-4">
            @foreach ($authors as $author)
                <a href="{{ route('authors.show', $author) }}" class="group block text-center">
                    <div class="aspect-square overflow-hidden rounded-3xl bg-sand ring-1 ring-black/5 transition duration-300 group-hover:-translate-y-1 group-hover:shadow-xl">
                        @if ($author->photo_url)
                            <img src="{{ $author->photo_url }}" alt="{{ $author->name }}" loading="lazy"
                                 class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center font-display text-5xl font-bold text-brand/40">
                                {{ Str::of($author->name)->explode(' ')->map(fn ($p) => Str::substr($p, 0, 1))->take(2)->join('') }}
                            </div>
                        @endif
                    </div>
                    <h2 class="mt-4 text-lg font-semibold transition group-hover:text-brand">{{ $author->name }}</h2>
                    @if ($author->role)
                        <p class="text-sm text-ink/60">{{ $author->role }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</x-shop-layout>