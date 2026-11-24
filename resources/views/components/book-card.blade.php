@props(['book'])
<a href="{{ route('books.show', $book) }}" class="group block">
    <div class="relative aspect-[4/5] overflow-hidden rounded-2xl bg-sand shadow-sm ring-1 ring-black/5 transition duration-300 group-hover:-translate-y-1 group-hover:shadow-xl">
        @if ($book->cover_url)
            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" loading="lazy"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center p-4 text-center text-sm text-ink/40">Cover coming soon</div>
        @endif
        @if ($book->is_on_sale)
            <span class="absolute left-3 top-3 rounded-full bg-orange-500 px-3 py-1 text-xs font-bold text-white shadow">Sale</span>
        @endif
    </div>
    <div class="mt-4 px-1">
        <h3 class="text-base font-semibold leading-snug transition group-hover:text-brand">{{ $book->title }}</h3>
        @if ($book->authors->isNotEmpty())
            <p class="mt-1 text-xs text-ink/60">{{ $book->authors->pluck('name')->join(', ') }}</p>
        @endif
        <p class="mt-2 text-sm">
            @if ($book->is_on_sale)
                <span class="font-bold text-brand">{{ \App\Support\Money::format($book->sale_price_cents) }}</span>
                <span class="ml-1 text-ink/40 line-through">{{ \App\Support\Money::format($book->price_cents) }}</span>
            @else
                <span class="font-bold text-brand">{{ \App\Support\Money::format($book->price_cents) }}</span>
            @endif
        </p>
    </div>
</a>