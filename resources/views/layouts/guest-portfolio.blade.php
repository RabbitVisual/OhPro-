<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portfolio do Aluno' }} - {{ config('app.name') }}</title>

    <!-- Fonts & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 bg-gray-50 dark:bg-gray-900 antialiased">

    {{-- Simple Header --}}
    <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-icon name="shapes" style="duotone" class="text-indigo-600 w-6 h-6" />
                <span class="font-display font-bold text-lg text-gray-900 dark:text-white">Vertex<span class="text-indigo-600">Oh!</span></span>
            </div>
            <div class="text-xs text-gray-500 font-medium">
                Portal dos Pais
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <footer class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} Vertex Oh Pro. Todos os direitos reservados.
    </footer>

</body>
</html>
