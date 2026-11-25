<x-shop-layout title="Meet the Authors" description="The authors published by Figs & Olives Publications.">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-4xl font-bold">Meet the Authors</h1>

        @if ($authors->isEmpty())
            <p class="mt-16 text-center text-ink/60">Author profiles are coming soon.</p>
        @else
            <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($authors as $author)
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/10">
                        @if ($author->photo_path)
                            <img src="{{ asset('storage/' . $author->photo_path) }}"
                                 alt="{{ $author->name }}"
                                 class="h-24 w-24 rounded-full object-cover">
                        @else
                            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-brand/10 text-3xl font-bold text-brand">
                                {{ Str::substr($author->name, 0, 1) }}
                            </div>
                        @endif

                        <h2 class="mt-4 text-xl font-semibold">{{ $author->name }}</h2>

                        @if ($author->bio)
                            <p class="mt-2 text-sm text-ink/70">{{ Str::limit($author->bio, 220) }}</p>
                        @else
                            <p class="mt-2 text-sm italic text-ink/50">Bio coming soon.</p>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-shop-layout>