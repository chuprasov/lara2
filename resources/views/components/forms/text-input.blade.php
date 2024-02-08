@props([
    'type' => 'text',
    'value' => '',
    'isError' => false,
])

<input type="{{ $type }}" value="{{ $value }}"
    {{ $attributes->class([
        '_is-error' => $isError,
        'w-full h-14 px-4 rounded-lg border border-black bg-white/20 text-black outline-none transition placeholder:text-darkblue text-xxs md:text-xs font-semibold',
    ]) }}>
