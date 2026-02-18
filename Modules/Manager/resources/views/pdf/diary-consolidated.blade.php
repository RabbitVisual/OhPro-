@extends('classrecord::pdf.layout')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <div class="mb-8 pb-4 border-b border-gray-200 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900">{{ $school->name }}</h1>
            <p class="text-sm text-gray-600 mt-1">Diário institucional — {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}</p>
        </div>
        @if($logoDataUrl ?? null)
        <img src="{{ $logoDataUrl }}" alt="Logo" class="h-14 w-auto object-contain" />
        @endif
    </div>

    @forelse($diaries as $diary)
    <div class="mb-8 pb-6 border-b border-gray-100">
        <p class="text-sm font-medium text-gray-500">{{ $diary->schoolClass->name ?? '—' }} · {{ $diary->schoolClass->subject ?? '—' }}</p>
        <p class="text-sm text-gray-600">Data: {{ $diary->scheduled_at?->translatedFormat('d/m/Y') ?? '—' }} — Professor(a): {{ $diary->user->full_name ?? '—' }}</p>
        @if($diary->content && !empty($diary->content['sections']))
        <div class="mt-2 space-y-1">
            @foreach($diary->content['sections'] ?? [] as $section)
            <p class="text-sm text-gray-700"><strong>{{ $section['field_key'] ?? '' }}:</strong> {{ Str::limit($section['value'] ?? '—', 200) }}</p>
            @endforeach
        </div>
        @endif
    </div>
    @empty
    <p class="text-gray-500">Nenhum registro de diário finalizado neste mês.</p>
    @endforelse
</div>
@endsection
