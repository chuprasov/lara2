@props([
    'type' => 'text',
    'value' => '',
    'isError' => false,
])

<input type="{{ $type }}" value="{{ $value }}"
    {{ $attributes->class([
        '_is-error' => $isError,
        'w-full h-14 px-4 rounded-lg border border-[#A07BF0] bg-white/20 outline-none transition text-white placeholder:text-white text-xxs md:text-xs font-semibold',
    ]) }}>
