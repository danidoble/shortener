@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-indigo-500 dark:focus:border-orange-600 focus:ring-indigo-500 dark:focus:ring-orange-600 rounded-md shadow-sm']) !!}>
