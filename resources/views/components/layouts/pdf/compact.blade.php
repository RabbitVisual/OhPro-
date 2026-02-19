@props(['title'])

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .page-break { page-break-after: always; }
        body { font-family: 'Courier New', Courier, monospace; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        th, td { border: 1px solid #9ca3af; padding: 4px; }
        th { background-color: #e5e7eb; font-weight: bold; text-align: left; }
    </style>
</head>
<body class="bg-white text-gray-900 p-4 text-xs">
    {{-- Compact Header --}}
    <header class="border-b border-gray-400 pb-2 mb-4 flex justify-between items-center">
        <div>
            <h1 class="font-bold text-sm">{{ $title }}</h1>
            <span class="text-[10px]">{{ auth()->user()->name }} | {{ now()->format('d/m/Y') }}</span>
        </div>
        @if(auth()->user()->logo_path)
            <img src="{{ auth()->user()->logo_url }}" class="h-6 w-auto object-contain grayscale opacity-75">
        @endif
    </header>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
