@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
      }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => {
          localStorage.setItem('theme', val ? 'dark' : 'light');
          if (val) {
              document.documentElement.classList.add('dark');
          } else {
              document.documentElement.classList.remove('dark');
          }
      })"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Oh Pro!') }}</title>
    <meta name="description" content="{{ $description ?? 'A plataforma completa para professores modernos. Planejamento com IA, diários digitais e muito mais.' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? 'A plataforma completa para professores modernos. Planejamento com IA, diários digitais e muito mais.' }}">
    <meta property="og:image" content="{{ $image ?? asset('assets/images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? config('app.name') }}">
    <meta property="twitter:description" content="{{ $description ?? 'A plataforma completa para professores modernos. Planejamento com IA, diários digitais e muito mais.' }}">
    <meta property="twitter:image" content="{{ $image ?? asset('assets/images/og-image.jpg') }}">

    <!-- Anti-Flicker Script -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts & Scripts (local fonts via app.css) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 bg-background dark:bg-background antialiased">
    <x-loading-overlay />

    {{ $slot }}
</body>
</html>
