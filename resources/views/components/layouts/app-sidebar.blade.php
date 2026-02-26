@php
    // Pass slot as already-rendered string so it is output only in the view's <main>, never in sidebar
    $slotHtml = (string) $slot;
@endphp
@include('layouts.app-sidebar', [
    'title' => $title ?? config('app.name', 'Oh Pro!'),
    'slot' => $slotHtml,
])
