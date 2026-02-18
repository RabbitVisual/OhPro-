@props([
    'feature' => 'Este recurso',
    'planRoute' => null,
])

@php
    $planRoute = $planRoute ?? route('plans');
@endphp

<div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-amber-300 dark:border-amber-600 bg-amber-50 dark:bg-amber-900/30 text-amber-800 dark:text-amber-200">
    <x-icon name="lock" style="duotone" class="fa-sm opacity-80" />
    <span class="text-sm font-medium">{{ $feature }} — disponível no plano Pro.</span>
    <a href="{{ $planRoute }}" class="shrink-0 px-3 py-1.5 rounded-lg bg-amber-600 text-white text-sm font-medium hover:bg-amber-700">
        Ver planos
    </a>
</div>
