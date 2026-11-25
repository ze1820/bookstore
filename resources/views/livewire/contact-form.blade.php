<div>
    @if ($sent)
        <p class="rounded-lg bg-green-50 p-4 text-green-800">Thank you, we received your message.</p>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="hidden" aria-hidden="true">
                <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" wire:model="name" class="mt-1 w-full rounded-lg border-gray-300">
                @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" wire:model="email" class="mt-1 w-full rounded-lg border-gray-300">
                @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Phone (optional)</label>
                <input type="text" wire:model="phone" class="mt-1 w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Message</label>
                <textarea wire:model="message" rows="5" class="mt-1 w-full rounded-lg border-gray-300"></textarea>
                @error('message') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="rounded-lg bg-[#7b4380] px-5 py-2 text-white hover:opacity-90">
                Send
            </button>
        </form>
    @endif
</div>