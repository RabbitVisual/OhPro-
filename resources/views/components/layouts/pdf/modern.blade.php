@props(['title'])

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .page-break { page-break-after: always; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-800 p-8">
    {{-- Modern Header --}}
    <header class="pb-6 mb-8 flex items-end justify-between">
        <div>
            <p class="text-xs font-bold text-indigo-600 tracking-wider uppercase mb-1">{{ auth()->user()->name }}</p>
            <h1 class="text-3xl font-bold text-slate-900 leading-tight">{{ $title }}</h1>
        </div>
        <div class="text-right">
            @if(auth()->user()->logo_path)
                <img src="{{ auth()->user()->logo_url }}" class="h-10 w-auto object-contain mb-2 ml-auto">
            @endif
            <p class="text-xs text-slate-400 font-medium">{{ now()->format('d M Y') }}</p>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="fixed bottom-8 left-8 right-8 flex justify-between text-[10px] text-slate-300 font-medium uppercase tracking-widest">
        <span>VertexOh! Pro</span>
        <span>Página <span class="page-number"></span></span>
    </footer>
</body>
</html>
