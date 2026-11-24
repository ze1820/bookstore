<x-shop-layout title="Shop" description="Browse all books from Figs & Olives Publications.">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-4xl font-bold">Shop</h1>
        <p class="mt-2 text-ink/70">{{ $books->total() }} {{ Str::plural('book', $books->total()) }}</p>

        <form method="GET" action="{{ route('shop.index') }}" class="mt-8 flex flex-wrap items-center gap-3">
            <input type="search" name="q" value="{{ $search }}" placeholder="Search by title or author"
                   class="w-full rounded-full border-0 bg-white px-5 py-3 text-sm shadow-sm ring-1 ring-black/10 transition focus:ring-2 focus:ring-brand sm:w-80">
            <select name="sort" onchange="this.form.submit()"
                    class="rounded-full border-0 bg-white px-5 py-3 text-sm shadow-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand">
                <option value="">Newest</option>
                <option value="title" @selected($sort === 'title')>Title A to Z</option>
                <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
            </select>
            <button class="rounded-full bg-brand px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-dark">Search</button>
            @if ($search !== '' || $sort !== '')
                <a href="{{ route('shop.index') }}" class="text-sm text-ink/60 hover:text-brand">Clear</a>
            @endif
        </form>

        @if ($books->isEmpty())
            <p class="mt-16 text-center text-ink/60">No books found. Try a different search.</p>
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