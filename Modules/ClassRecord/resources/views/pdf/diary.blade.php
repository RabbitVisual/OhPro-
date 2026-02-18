@extends('classrecord::pdf.layout')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    {{-- School & header --}}
    <div class="mb-8 pb-4 border-b border-gray-200 flex items-start justify-between gap-4">
        <div>
        <h1 class="text-2xl font-display font-bold text-gray-900">{{ $diary->schoolClass->school->name ?? config('app.name') }}</h1>
        <p class="text-sm text-gray-600 mt-1">Professor(a): {{ auth()->user()->name ?? '' }}</p>
        <p class="text-sm text-gray-600">Disciplina/Turma: {{ $diary->schoolClass->subject ?? '—' }} · {{ $diary->schoolClass->name ?? '' }}</p>
        <p class="text-sm text-gray-600">Data: {{ $diary->scheduled_at?->translatedFormat('d/m/Y') ?? $diary->started_at?->translatedFormat('d/m/Y') ?? '—' }}</p>
        </div>
        @if($logoDataUrl ?? null)
        <img src="{{ $logoDataUrl }}" alt="Logo" class="h-14 w-auto object-contain" />
        @endif
    </div>

    {{-- Lesson plan content --}}
    @if($diary->content && !empty($diary->content['sections']))
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ $diary->content['title'] ?? 'Conteúdo do plano' }}</h2>
            <div class="space-y-3">
                @foreach($diary->content['sections'] ?? [] as $section)
                    <div>
                        <span class="text-sm font-medium text-gray-500">{{ $section['field_key'] ?? '' }}</span>
                        <p class="text-gray-900">{{ $section['value'] ?? '—' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Digital signature --}}
    @if($signatureDataUrl ?? null)
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm font-medium text-gray-600 mb-2">Assinatura do professor</p>
            <img src="{{ $signatureDataUrl }}" alt="Assinatura" class="max-w-xs h-auto border border-gray-300 rounded">
        </div>
    @endif
</div>
@endsection
