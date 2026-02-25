@props(['route', 'icon', 'label', 'active' => false])

@php
$isActive = request()->routeIs($active);
$classes = $isActive
    ? 'group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 transition-colors'
    : 'group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors';

$iconClasses = $isActive
    ? 'mr-3 h-5 w-5 text-indigo-600 dark:text-indigo-400 shrink-0'
    : 'mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-500 dark:group-hover:text-slate-300 shrink-0';
@endphp

<a href="{{ route($route) }}" {{ $attributes->merge(['class' => $classes]) }}>
    <x-icon :name="$icon" style="duotone" class="{{ $iconClasses }}" />
    {{ $label }}
</a>
