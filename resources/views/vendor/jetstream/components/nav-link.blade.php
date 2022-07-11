@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-teal-400 text-sm font-medium leading-5 text-teal-700 focus:outline-none focus:border-teal-700 transition'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-teal-500 hover:text-teal-400 hover:border-teal-300 focus:outline-none focus:text-teal-500 focus:border-teal-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
