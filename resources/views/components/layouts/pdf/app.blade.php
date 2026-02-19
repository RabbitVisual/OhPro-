@props(['theme' => 'classic', 'title'])

@php
    $themeComponent = match($theme) {
        'modern' => 'layouts.pdf.modern',
        'compact' => 'layouts.pdf.compact',
        default => 'layouts.pdf.classic',
    };
@endphp

<x-dynamic-component :component="$themeComponent" :title="$title" {{ $attributes }}>
    {{ $slot }}
</x-dynamic-component>
