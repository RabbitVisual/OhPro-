@props(['title'])

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .page-break { page-break-after: always; }
        body { font-family: 'Helvetica', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-900 p-8">
    {{-- Classic Header --}}
    <header class="border-b-2 border-gray-300 pb-4 mb-6 flex justify-between items-center bg-gray-50 p-4 rounded-lg">
        <div class="flex items-center gap-4">
            {{-- Logo Placeholder --}}
            @if(auth()->user()->logo_path)
                <img src="{{ auth()->user()->logo_url }}" class="h-12 w-auto object-contain">
            @else
                <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 font-bold">Logo</div>
            @endif
            <div>
                <h1 class="text-xl font-bold uppercase tracking-wide">{{ $title }}</h1>
                <p class="text-xs text-gray-500">{{ auth()->user()->name }}</p>
            </div>
        </div>
        <div class="text-right text-xs text-gray-500">
            <p>{{ now()->format('d/m/Y H:i') }}</p>
            <p>VertexOh! Pro</p>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-8 pt-4 border-t border-gray-200 text-center text-xs text-gray-400">
        Gerado por VertexOh! Pro - Gestão Escolar Inteligente
    </footer>
</body>
</html>
