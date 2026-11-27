<x-shop-layout title="Shop" description="Browse all books from Figs & Olives Publications.">
    @php
        $filters = fn (array $extra = []) => array_filter(
            array_merge(['category' => $category, 'q' => $search, 'sort' => $sort], $extra),
            fn ($v) => $v !== null && $v !== ''
        );
        $isFiltered = $search !== '' || $sort !== '' || $category !== '';
    @endphp

    <!-- <div class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-4xl font-bold">Shop</h1>
        <p class="mt-2 text-ink/70">
            @if ($books->total() > 0)
                Showing {{ $books->firstItem() }}&ndash;{{ $books->lastItem() }} of {{ $books->total() }} {{ Str::plural('book', $books->total()) }}
            @else
                0 books
            @endif
        </p>
    </div> -->

    {{-- Sticky filter bar --}}
    <div class="sticky top-16 z-10 border-y border-black/5 bg-cream/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-3 md:flex-row md:items-center md:justify-between">
            @if ($categories->isNotEmpty())
                <nav class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1 md:pb-0" aria-label="Categories">
                    <a href="{{ route('shop.index', $filters(['category' => null])) }}"
                       @if ($category === '') aria-current="true" @endif
                       class="whitespace-nowrap rounded-full bg-white px-4 py-2 text-sm font-medium ring-1 ring-black/10 transition hover:ring-brand aria-[current=true]:bg-brand aria-[current=true]:text-white aria-[current=true]:ring-brand">All</a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('shop.index', $filters(['category' => $cat->slug])) }}"
                           @if ($category === $cat->slug) aria-current="true" @endif
                           class="whitespace-nowrap rounded-full bg-white px-4 py-2 text-sm font-medium ring-1 ring-black/10 transition hover:ring-brand aria-[current=true]:bg-brand aria-[current=true]:text-white aria-[current=true]:ring-brand">{{ $cat->name }}</a>
                    @endforeach
                </nav>
            @endif

            <form method="GET" action="{{ route('shop.index') }}" class="flex flex-wrap items-center gap-2">
                @if ($category !== '')
                    <input type="hidden" name="category" value="{{ $category }}">
                @endif
                <input type="search" name="q" value="{{ $search }}" placeholder="Search by title or author"
                       class="w-full rounded-full border-0 bg-white px-5 py-2.5 text-sm shadow-sm ring-1 ring-black/10 transition focus:ring-2 focus:ring-brand sm:w-64">
                <select name="sort" onchange="this.form.submit()"
                        class="rounded-full border-0 bg-white px-4 py-2.5 text-sm shadow-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand">
                    <option value="">Newest</option>
                    <option value="title" @selected($sort === 'title')>Title A to Z</option>
                    <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                    <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
                </select>
                <button class="rounded-full bg-brand px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark">Search</button>
                @if ($isFiltered)
                    <a href="{{ route('shop.index') }}" class="text-sm text-ink/60 hover:text-brand">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <div class="mx-auto max-w-6xl px-4 pb-12">
        @if ($books->isEmpty())
            <div class="mt-16 rounded-3xl bg-white px-6 py-14 text-center ring-1 ring-black/5">
                <p class="text-lg font-semibold">
                    @if ($search !== '')
                        No books match &ldquo;{{ $search }}&rdquo;
                    @else
                        No books in this category yet
                    @endif
                </p>
                <p class="mt-2 text-sm text-ink/60">Try a different search or browse everything.</p>
                <a href="{{ route('shop.index') }}"
                   class="mt-6 inline-block rounded-full bg-brand px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-dark">View all books</a>
            </div>
        @else
            <div class="mt-10 grid grid-cols-2 gap-x-5 gap-y-10 md:grid-cols-4">
                @foreach ($books as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>
            <div class="mt-12">{{ $books->links() }}</div>
        @endif
    </div>
</x-shop-layout>
