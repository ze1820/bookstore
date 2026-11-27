<x-shop-layout :title="$book->title" :description="$book->short_description ?? $book->description">
    @php
        $hasDimensions = $book->length_mm && $book->width_mm && $book->height_mm;
        $facts = array_filter([
            'Pages' => $book->pages,
            'Format' => $book->format,
            'Language' => $book->language,
            'Publisher' => $book->publisher,
        ]);
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-10">
        <nav class="mb-8 text-sm text-ink/60">
            <a href="{{ route('shop.index') }}" class="hover:text-brand">Shop</a>
            <span class="mx-2">/</span>{{ $book->title }}
        </nav>

        <div class="grid gap-12 md:grid-cols-2">
            {{-- Gallery: auto-swapping slideshow --}}
            <div data-slideshow data-interval="4500" data-pause-on-hover class="md:sticky md:top-28 md:self-start">
                <div class="relative aspect-square overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-black/5">
                    @forelse ($book->images as $image)
                        <img data-slide src="{{ $image->url }}" alt="{{ $loop->first ? $book->title : '' }}"
                             @if (! $loop->first) loading="lazy" aria-hidden="true" @endif
                             class="absolute inset-0 h-full w-full object-contain transition-opacity duration-700 {{ $loop->first ? 'opacity-100' : 'opacity-0' }}">
                    @empty
                        <div class="flex h-full items-center justify-center text-ink/40">Cover coming soon</div>
                    @endforelse

                    @if ($book->images->count() > 1)
                        <button type="button" data-prev aria-label="Previous image"
                                class="absolute left-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/90 p-2 shadow ring-1 ring-black/5 transition hover:bg-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button type="button" data-next aria-label="Next image"
                                class="absolute right-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/90 p-2 shadow ring-1 ring-black/5 transition hover:bg-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    @endif
                </div>

                <!-- @if ($book->images->count() > 1)
                    <div class="mt-4 flex gap-3">
                        @foreach ($book->images as $image)
                            <button type="button" data-go="{{ $loop->index }}" aria-label="Show image {{ $loop->iteration }}"
                                    class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-white opacity-60 ring-1 ring-black/5 transition hover:opacity-100 aria-[current=true]:opacity-100 aria-[current=true]:ring-2 aria-[current=true]:ring-brand"
                                    @if ($loop->first) aria-current="true" @endif>
                                <img src="{{ $image->url }}" alt="" loading="lazy" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif -->
            </div>

            {{-- Summary --}}
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

                @if ($book->is_sold_out)
                    <p class="mt-3 text-sm font-semibold text-ink/70">Currently sold out</p>
                @elseif ($book->is_low_stock)
                    <p class="mt-3 text-sm font-semibold text-orange-600">Only {{ $book->stock }} left in stock</p>
                @endif

                @if ($book->short_description)
                    <p class="mt-5 leading-relaxed text-ink/80">{{ $book->short_description }}</p>
                @endif

                <div class="mt-6 flex flex-wrap gap-3">
                    <button disabled
                            class="cursor-not-allowed rounded-full bg-brand/40 px-8 py-4 text-sm font-semibold text-white">
                        Add to cart (coming soon)
                    </button>

                    @if ($book->demo_pdf_url)
                        <button type="button" data-open-tab="sample"
                                class="inline-flex items-center gap-2 rounded-full border border-brand px-6 py-4 text-sm font-semibold text-brand transition hover:bg-brand hover:text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.25v13m0-13C10.8 5.5 9.2 5 7.5 5S4.2 5.5 3 6.25v13C4.2 18.5 5.8 18 7.5 18s3.3.5 4.5 1.25m0-13C13.2 5.5 14.8 5 16.5 5s3.3.5 4.5 1.25v13C19.8 18.5 18.2 18 16.5 18s-3.3.5-4.5 1.25"/></svg>
                            Read a free sample
                        </button>
                    @endif
                </div>

                @if ($facts)
                    <dl class="mt-8 grid grid-cols-2 gap-3 text-sm">
                        @foreach ($facts as $label => $value)
                            <div class="rounded-2xl bg-white px-4 py-3 ring-1 ring-black/5">
                                <dt class="text-xs uppercase tracking-wide text-ink/50">{{ $label }}</dt>
                                <dd class="mt-0.5 font-medium">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif

                <ul class="mt-6 space-y-2 text-sm text-ink/70">
                    <li>&#10003; Secure checkout</li>
                    <li>&#10003; 7-day returns on sealed books</li>
                </ul>
            </div>
        </div>

        {{-- Tabs: About / Details / Sample --}}
        <div data-tabs class="mt-14">
            <div role="tablist" class="flex gap-1 overflow-x-auto border-b border-black/10">
                <button type="button" role="tab" data-tab="about" aria-selected="true"
                        class="whitespace-nowrap border-b-2 border-transparent px-5 py-3 text-sm font-semibold text-ink/60 transition hover:text-brand aria-selected:border-brand aria-selected:text-brand">About this book</button>
                <button type="button" role="tab" data-tab="details" aria-selected="false"
                        class="whitespace-nowrap border-b-2 border-transparent px-5 py-3 text-sm font-semibold text-ink/60 transition hover:text-brand aria-selected:border-brand aria-selected:text-brand">Details</button>
                @if ($book->demo_pdf_url)
                    <button type="button" role="tab" data-tab="sample" aria-selected="false"
                            class="whitespace-nowrap border-b-2 border-transparent px-5 py-3 text-sm font-semibold text-ink/60 transition hover:text-brand aria-selected:border-brand aria-selected:text-brand">Free sample</button>
                @endif
            </div>

            <div data-panel="about" class="pt-8">
                @if ($book->description)
                    <div class="book-description max-w-3xl text-ink/80 md:columns-2 md:gap-12 [&>*]:break-inside-avoid-column">{!! $book->description !!}</div>
                @else
                    <p class="text-ink/60">Description coming soon.</p>
                @endif
            </div>

            <div data-panel="details" class="hidden pt-8">
                <dl class="grid gap-3 text-sm sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        'Pages' => $book->pages,
                        'Format' => $book->format,
                        'Language' => $book->language,
                        'Publisher' => $book->publisher,
                        'ISBN' => $book->isbn,
                        'Published' => $book->published_at?->format('F j, Y'),
                        'Weight' => $book->weight_grams ? $book->weight_grams.' g' : null,
                        'Size' => $hasDimensions ? "{$book->length_mm} × {$book->width_mm} × {$book->height_mm} mm" : null,
                    ] as $label => $value)
                        @if ($value)
                            <div class="rounded-2xl bg-white px-5 py-4 ring-1 ring-black/5">
                                <dt class="text-xs uppercase tracking-wide text-ink/50">{{ $label }}</dt>
                                <dd class="mt-1 font-medium">{{ $value }}</dd>
                            </div>
                        @endif
                    @endforeach
                </dl>
            </div>

            @if ($book->demo_pdf_url)
                <div data-panel="sample" class="hidden pt-8">
                    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm text-ink/70">Preview the first pages before you buy.</p>
                        <a href="{{ $book->demo_pdf_url }}" target="_blank" rel="noopener"
                           class="rounded-full bg-brand px-5 py-2 text-sm font-semibold text-white transition hover:bg-brand-dark">Open in a new tab</a>
                    </div>
                    <iframe src="{{ $book->demo_pdf_url }}#toolbar=0" title="Sample of {{ $book->title }}" loading="lazy"
                            class="h-[75vh] w-full rounded-2xl bg-white ring-1 ring-black/10"></iframe>
                </div>
            @endif
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
