@props(['book'])
@php($covers = $book->images)
<a href="{{ route('books.show', $book) }}" class="group block">
    <div data-slideshow data-interval="3500"
         class="relative aspect-[4/5] overflow-hidden rounded-2xl bg-sand shadow-sm ring-1 ring-black/5 transition duration-300 group-hover:-translate-y-1 group-hover:shadow-xl">
        @forelse ($covers as $image)
            <img data-slide src="{{ $image->url }}" alt="{{ $loop->first ? $book->title : '' }}"
                 @if (! $loop->first) loading="lazy" aria-hidden="true" @endif
                 class="absolute inset-0 h-full w-full object-cover transition-opacity duration-700 {{ $book->is_sold_out ? 'grayscale-[40%]' : '' }} {{ $loop->first ? 'opacity-100' : 'opacity-0' }}">
        @empty
            <div class="flex h-full items-center justify-center p-4 text-center text-sm text-ink/40">Cover coming soon</div>
        @endforelse

        <div class="absolute left-3 top-3 z-10 flex flex-col items-start gap-1.5">
            @if ($book->is_on_sale)
                <span class="rounded-full bg-orange-500 px-3 py-1 text-xs font-bold text-white shadow">Sale</span>
            @endif
            @if ($book->is_sold_out)
                <span class="rounded-full bg-ink px-3 py-1 text-xs font-bold text-white shadow">Sold out</span>
            @endif
        </div>

        @if ($book->demo_pdf_path)
            <span class="absolute right-3 top-3 z-10 rounded-full bg-olive px-3 py-1 text-xs font-bold text-white shadow">Free sample</span>
        @endif

        @if ($covers->count() > 1)
            <div class="absolute inset-x-0 bottom-3 z-10 flex justify-center gap-1.5" aria-hidden="true">
                @foreach ($covers as $image)
                    <span data-dot class="h-1.5 w-1.5 rounded-full bg-white/60 shadow transition-all aria-[current=true]:w-4 aria-[current=true]:bg-white"
                          @if ($loop->first) aria-current="true" @endif></span>
                @endforeach
            </div>
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
        @if ($book->is_low_stock)
            <p class="mt-1 text-xs font-medium text-orange-600">Only {{ $book->stock }} left</p>
        @endif
    </div>
</a>
