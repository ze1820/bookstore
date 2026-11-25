@props(['name', 'label', 'type' => 'text', 'required' => false, 'options' => null, 'rows' => 4])
@php
    $base = 'mt-1 w-full rounded-xl border-0 bg-cream px-4 py-3 text-sm ring-1 ring-black/10 focus:ring-2 focus:ring-brand';
@endphp
<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="text-sm font-medium">{{ $label }}@if ($required) *@endif</label>

    @if ($options)
        <select id="{{ $name }}" name="{{ $name }}" @required($required) class="{{ $base }}">
            <option value="">Choose one</option>
            @foreach ($options as $option)
                <option value="{{ $option }}" @selected(old($name) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" @required($required) class="{{ $base }}">{{ old($name) }}</textarea>
    @else
        <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ old($name) }}" @required($required) class="{{ $base }}">
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>