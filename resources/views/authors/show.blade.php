<x-shop-layout :title="$author->name" :description="$author->bio">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <nav class="mb-8 text-sm text-ink/60">
            <a href="{{ route('authors.index') }}" class="hover:text-brand">Authors</a>
            <span class="mx-2">/</span>{{ $author->name }}
        </nav>

        <div class="grid gap-10 md:grid-cols-3">
            <div class="aspect-square overflow-hidden rounded-3xl bg-sand ring-1 ring-black/5">
                @if ($author->photo_url)
                    <img src="{{ $author->photo_url }}" alt="{{ $author->name }}" class="h-full w-full object-cover">
                @endif
            </div>
            <div class="md:col-span-2">
                <h1 class="text-4xl font-bold">{{ $author->name }}</h1>
                @if ($author->role)
                    <p class="mt-2 text-olive">{{ $author->role }}</p>
                @endif
                @if ($author->bio)
                    <div class="mt-6 whitespace-pre-line leading-relaxed text-ink/80">{{ $author->bio }}</div>
                @else
                    <p class="mt-6 text-ink/50">Biography coming soon.</p>
                @endif
            </div>
        </div>

        @if ($books->isNotEmpty())
            <h2 class="mt-20 text-3xl font-bold">Books by {{ $author->name }}</h2>
            <div class="mt-8 grid grid-cols-2 gap-x-5 gap-y-10 md:grid-cols-4">
                @foreach ($books as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>
        @endif
    </div>
</x-shop-layout>