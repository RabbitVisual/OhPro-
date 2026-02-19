<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $plan->title }}</title>
    <style>
        body { font-family: 'Inter', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; margin: 0; }
        .meta { color: #666; font-size: 12px; margin-top: 5px; }
        .section { margin-bottom: 20px; page-break-inside: avoid; }
        .section-title { font-size: 14px; font-weight: bold; color: #4f46e5; text-transform: uppercase; margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 4px; }
        .content { font-size: 13px; }
        .watermark {
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px; color: rgba(0,0,0,0.05); font-weight: bold; pointer-events: none; z-index: 9999;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    @if(!empty($watermark_text))
        <div class="watermark">{{ $watermark_text }}</div>
    @endif

    <div class="header">
        <h1 class="title">{{ $plan->title }}</h1>
        <div class="meta">
            Autor: {{ $plan->user->name }} • Criado em: {{ $plan->created_at->format('d/m/Y') }}
        </div>
    </div>

    @foreach($plan->contents->sortBy('sort_order') as $content)
        <div class="section">
            <h3 class="section-title">{{ ucwords(str_replace('_', ' ', $content->field_key)) }}</h3>
            <div class="content">
                {!! nl2br(e($content->value)) !!}
            </div>
        </div>
    @endforeach

    @if($plan->notes)
        <div class="section">
            <h3 class="section-title">Notas</h3>
            <div class="content">
                {!! nl2br(e($plan->notes)) !!}
            </div>
        </div>
    @endif
</body>
</html>
