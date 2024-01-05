@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-3/4 pl-3 pr-4 py-2 border-l-4 border-indigo-400  text-left text-base font-medium text-white  bg-indigo-50   focus:outline-none focus:text-indigo-800 focus:bg-indigo-100  focus:border-indigo-700 dark:border-indigo-600 dark:text-indigo-300 dark:bg-indigo-900/50 dark:focus:text-indigo-200 dark:focus:bg-indigo-900  dark:focus:border-indigo-300 transition duration-150 ease-in-out'
            : 'block w-3/4 pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-white   hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 dark:text-gray-400 focus:outline-none focus:text-gray-800 focus:border-gray-300 dark:focus:bg-gray-700 dark:hover:text-gray-200 dark:hover:bg-gray-700  dark:hover:border-gray-600  dark:focus:text-gray-200 focus:bg-gray-50   dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
