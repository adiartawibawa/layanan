@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center px-3 py-2 text-gray-700 bg-gray-100 transition-colors duration-300 transform rounded-lg dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700 transition duration-150 ease-in-out'
            : 'flex items-center px-3 py-2 text-gray-600 transition-colors duration-300 transform rounded-lg dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700 transition duration-150 ease-in-out';
@endphp


<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
