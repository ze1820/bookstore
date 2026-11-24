<x-shop-layout description="Islamic books for children and adults, with workbooks and courses.">

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-16 md:grid-cols-2 md:py-24">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-olive">Figs &amp; Olives Publications</p>
                <h1 class="mt-4 text-4xl font-bold leading-[1.1] md:text-6xl">
                    Books that speak to the <span class="text-brand">soul</span>.
                </h1>
                <p class="mt-6 max-w-lg text-lg leading-relaxed text-ink/70">
                    Our books help your children, and you, grow closer to God through story,
                    reflection, and meaningful conversation.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('shop.index') }}"
                       class="rounded-full bg-brand px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand/30 transition hover:-translate-y-0.5 hover:bg-brand-dark">
                        Shop the books
                    </a>
                    <a href="#why"
                       class="rounded-full px-7 py-3.5 text-sm font-semibold text-brand ring-1 ring-brand/30 transition hover:bg-brand-50">
                        Our approach
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-6 -z-10 rounded-[2.5rem] bg-brand-100/60"></div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($books->take(2) as $i => $book)
                        <a href="{{ route('books.show', $book) }}"
                           class="block overflow-hidden rounded-2xl bg-sand shadow-xl ring-1 ring-black/5 transition hover:-translate-y-1 {{ $i === 1 ? 'mt-10' : '' }}">
                            @if ($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="aspect-[4/5] w-full object-cover">
                            @else
                                <div class="flex aspect-[4/5] items-center justify-center text-sm text-ink/40">Cover coming soon</div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Featured books --}}
    <section class="mx-auto max-w-6xl px-4">
        <div class="flex items-end justify-between">
            <h2 class="text-3xl font-bold">Our books</h2>
            <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-brand hover:underline">View all &rarr;</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-x-5 gap-y-10 md:grid-cols-4">
            @foreach ($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>
    </section>

    {{-- Approach --}}
    <section id="why" class="mx-auto mt-24 max-w-6xl scroll-mt-24 px-4">
        <div class="rounded-3xl bg-white px-6 py-14 shadow-sm ring-1 ring-black/5 md:px-14">
            <h2 class="text-center text-3xl font-bold">Books. Courses. Workbooks. A holistic approach.</h2>
            <p class="mx-auto mt-4 max-w-2xl text-center text-ink/70">
                Books alone are not enough. The conversation we have afterward matters more than the literature itself.
            </p>
            <div class="mt-12 grid gap-8 md:grid-cols-4">
                @foreach ([
                    ['1', 'Read the book', 'Stories that open the door to important conversations.'],
                    ['2', 'Join a workshop', 'Learn together and go deeper into the message.'],
                    ['3', 'Use the workbook', 'Printable activities that reinforce what was read.'],
                    ['4', 'Talk one-on-one', 'Personal sessions for private questions.'],
                ] as [$n, $head, $text])
                    <div class="text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 font-display text-lg font-bold text-brand">{{ $n }}</div>
                        <h3 class="mt-4 font-semibold">{{ $head }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink/70">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Closing call to action --}}
    <section class="mx-auto mt-24 max-w-6xl px-4">
        <div class="rounded-3xl bg-brand px-6 py-14 text-center text-white md:px-14">
            <h2 class="text-3xl font-bold md:text-4xl">Start the conversation today.</h2>
            <p class="mx-auto mt-4 max-w-xl text-white/80">Find the right book for your family.</p>
            <a href="{{ route('shop.index') }}"
               class="mt-8 inline-block rounded-full bg-white px-8 py-3.5 text-sm font-semibold text-brand transition hover:-translate-y-0.5 hover:shadow-xl">
                Browse the shop
            </a>
        </div>
    </section>
</x-shop-layout>