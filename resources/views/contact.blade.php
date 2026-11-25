<x-shop-layout title="Contact us" description="Questions, feedback or bulk orders? Get in touch with Figs & Olives Publications.">
    <div class="mx-auto max-w-3xl px-4 py-12">
        <h1 class="text-4xl font-bold">Contact us</h1>
        <p class="mt-3 text-ink/70">
            We value your feedback and questions. Fill in the form, or write to
            <a href="mailto:admin@fopublications.com" class="font-medium text-brand hover:underline">admin@fopublications.com</a>.
        </p>

        @if (session('sent'))
            <div class="mt-8 rounded-2xl bg-olive/10 px-5 py-4 text-sm font-medium text-olive ring-1 ring-olive/20" role="status">
                Thank you. Your message was sent and we will reply soon.
            </div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}" class="mt-8 space-y-5 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5 md:p-8">
            @csrf

            {{-- Spam trap: hidden from people --}}
            <div class="hidden" aria-hidden="true">
                <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="text-sm font-medium">Name *</label>
                    <input id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                           class="mt-1 w-full rounded-xl border-0 bg-cream px-4 py-3 text-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="text-sm font-medium">Email *</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           class="mt-1 w-full rounded-xl border-0 bg-cream px-4 py-3 text-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="text-sm font-medium">Phone</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                           class="mt-1 w-full rounded-xl border-0 bg-cream px-4 py-3 text-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="reason" class="text-sm font-medium">Reason for contacting us</label>
                    <select id="reason" name="reason"
                            class="mt-1 w-full rounded-xl border-0 bg-cream px-4 py-3 text-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand">
                        <option value="">Choose one</option>
                        @foreach ($reasons as $reason)
                            <option value="{{ $reason }}" @selected(old('reason') === $reason)>{{ $reason }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="whatsapp_ok" value="1" @checked(old('whatsapp_ok')) class="rounded text-brand focus:ring-brand">
                You can contact me on WhatsApp
            </label>

            <div>
                <label for="message" class="text-sm font-medium">What would you like to tell us? *</label>
                <textarea id="message" name="message" rows="6" required
                          class="mt-1 w-full rounded-xl border-0 bg-cream px-4 py-3 text-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand">{{ old('message') }}</textarea>
                @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button class="rounded-full bg-brand px-8 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-brand-dark">
                Send message
            </button>
        </form>
    </div>
</x-shop-layout>