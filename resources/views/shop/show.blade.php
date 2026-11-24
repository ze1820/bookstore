<x-shop-layout :title="$book->title" :description="$book->short_description ?? $book->description">
    <div class="mx-auto max-w-6xl px-4 py-10">
        <nav class="mb-8 text-sm text-ink/60">
            <a href="{{ route('shop.index') }}" class="hover:text-brand">Shop</a>
            <span class="mx-2">/</span>{{ $book->title }}
        </nav>

        <div class="grid gap-12 md:grid-cols-2">
            {{-- Gallery --}}
            <div class="md:sticky md:top-28 md:self-start">
                <div class="aspect-square overflow-hidden rounded-3xl bg-sand shadow-sm ring-1 ring-black/5">
                    @if ($book->images->isNotEmpty())
                        <img id="main-image" src="{{ $book->images->first()->url }}" alt="{{ $book->title }}"
                             class="h-full w-full object-contain transition duration-300">
                    @else
                        <div class="flex h-full items-center justify-center text-ink/40">Cover coming soon</div>
                    @endif
                </div>
                @if ($book->images->count() > 1)
                    <div class="mt-4 grid grid-cols-5 gap-3">
                        @foreach ($book->images as $image)
                            <button type="button" data-src="{{ $image->url }}"
                                    onclick="document.getElementById('main-image').src = this.dataset.src"
                                    class="aspect-square overflow-hidden rounded-xl bg-sand ring-1 ring-black/5 transition hover:ring-2 hover:ring-brand">
                                <img src="{{ $image->url }}" alt="" loading="lazy" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div>
                @if ($book->is_on_sale)
                    <span class="rounded-full bg-orange-500 px-3 py-1 text-xs font-bold text-white">Sale</span>
                @endif
                <h1 class="mt-3 text-4xl font-bold leading-tight">{{ $book->title }}</h1>

                @if ($book->authors->isNotEmpty())
                    <p class="mt-3 text-ink/70">By <span class="font-medium text-ink">{{ $book->authors->pluck('name')->join(', ') }}</span></p>
                @endif

                <p class="mt-6 flex items-baseline gap-3">
                    @if ($book->is_on_sale)
                        <span class="text-3xl font-bold text-brand">{{ \App\Support\Money::format($book->sale_price_cents) }}</span>
                        <span class="text-lg text-ink/40 line-through">{{ \App\Support\Money::format($book->price_cents) }}</span>
                    @else
                        <span class="text-3xl font-bold text-brand">{{ \App\Support\Money::format($book->price_cents) }}</span>
                    @endif
                </p>

                <button disabled
                        class="mt-6 w-full cursor-not-allowed rounded-full bg-brand/40 px-8 py-4 text-sm font-semibold text-white sm:w-auto">
                    Add to cart (coming soon)
                </button>

                <ul class="mt-6 space-y-2 text-sm text-ink/70">
                    <li>&#10003; Secure checkout</li>
                    <li>&#10003; 7-day returns on sealed books</li>
                </ul>

                @if ($book->description)
                    <div class="book-description mt-10 border-t border-black/10 pt-8 text-ink/80">{!! $book->description !!}</div>
                @endif

                <dl class="mt-8 grid grid-cols-2 gap-y-3 border-t border-black/10 pt-6 text-sm">
                    @if ($book->pages)<dt class="text-ink/50">Pages</dt><dd>{{ $book->pages }}</dd>@endif
                    @if ($book->weight_grams)<dt class="text-ink/50">Weight</dt><dd>{{ $book->weight_grams }} g</dd>@endif
                    @if ($book->publisher)<dt class="text-ink/50">Publisher</dt><dd>{{ $book->publisher }}</dd>@endif
                    @if ($book->isbn)<dt class="text-ink/50">ISBN</dt><dd>{{ $book->isbn }}</dd>@endif
                </dl>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <h2 class="mt-24 text-3xl font-bold">You may also like</h2>
            <div class="mt-8 grid grid-cols-2 gap-x-5 gap-y-10 md:grid-cols-4">
                @foreach ($related as $item)
                    <x-book-card :book="$item" />
                @endforeach
            </div>
        @endif
    </div>
</x-shop-layout>