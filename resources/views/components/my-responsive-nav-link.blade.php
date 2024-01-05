@props(['active'])

@php
    $classes = 'hover:bg-white hover:text-black block w-auto pl-3 pr-4 py-1 text-left text-base font-medium transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
