@php
    $layoutTitle = $title ?? config('app.name', 'Oh Pro!');
@endphp
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
    <title>{{ $layoutTitle }}</title>
    <link rel="manifest" href="/manifest.json">
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans text-gray-900 bg-background dark:bg-background antialiased w-full min-w-0 overflow-x-hidden">
    <x-offline-indicator />
    <x-loading-overlay />
    <x-toast-container />

    <div x-data="{ sidebarOpen: false }" class="h-screen w-full min-w-0 overflow-hidden bg-slate-50 dark:bg-slate-950">
        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

        {{-- Main Grid --}}
        <div class="grid grid-cols-[0_1fr] lg:grid-cols-[16rem_1fr] h-full w-full min-w-0 overflow-hidden">
            {{-- Sidebar --}}
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 lg:relative lg:inset-0 lg:translate-x-0 lg:w-full bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none flex flex-col min-h-0 shrink-0">
                <div class="flex flex-col h-full w-full min-w-0">
                    <div class="flex items-center justify-center h-16 shrink-0 border-b border-slate-200 dark:border-slate-800 px-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-display font-bold text-xl text-slate-900 dark:text-white hover:opacity-90 transition-opacity">
                            <x-icon name="chalkboard-user" style="duotone" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                            <span>Oh <span class="text-indigo-600 dark:text-indigo-400">Pro!</span></span>
                        </a>
                    </div>
                    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto min-h-0 custom-scrollbar">
                        @role('teacher')
                            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Professor</p>
                            <x-nav-link route="teacher.index" icon="chart-pie" label="Visão geral" active="teacher.index" />
                            <x-nav-link route="teacher.wallet" icon="wallet" label="Carteira" active="teacher.wallet" />
                            <x-nav-link route="teacher.stats" icon="chart-line" label="Meu Ano em Dados" active="teacher.stats" />
                            <x-nav-link route="workspace.index" icon="chalkboard" label="Workspace" active="workspace.*" />
                            <x-nav-link route="planning.index" icon="calendar-alt" label="Planejamento" active="planning.*" />
                            <x-nav-link route="notebook.index" icon="book" label="Caderno" active="notebook.*" />
                            <x-nav-link route="diary.index" icon="pen-to-square" label="Diário" active="diary.*" />
                            <x-nav-link route="library.index" icon="books" label="Biblioteca" active="library.*" />
                        @endrole
                        @role('manager')
                            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Gestão</p>
                            <x-nav-link route="dashboard" icon="chart-pie" label="Dashboard" active="dashboard" />
                        @endrole
                        @role('admin')
                            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Administração</p>
                            <x-nav-link route="panel.admin" icon="tachometer-alt" label="Dashboard" active="panel.admin" />
                            <x-nav-link route="panel.admin.users.index" icon="users" label="Usuários" active="panel.admin.users.*" />
                            <x-nav-link route="panel.admin.plans.index" icon="tags" label="Planos" active="panel.admin.plans.*" />
                            <x-nav-link route="panel.admin.subscriptions" icon="credit-card" label="Assinaturas" active="panel.admin.subscriptions*" />
                            <x-nav-link route="panel.admin.tickets.index" icon="ticket-alt" label="Tickets" active="panel.admin.tickets.*" />
                            <x-nav-link route="panel.admin.health" icon="heartbeat" label="Saúde do Sistema" active="panel.admin.health" />
                        @endrole
                        @role('teacher')
                            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Ajuda</p>
                            <x-nav-link route="support.index" icon="life-ring" label="Suporte" active="support.*" />
                        @endrole
                        <div class="mt-auto pt-4 border-t border-slate-200 dark:border-slate-800">
                            <x-nav-link route="profile.edit" icon="user-circle" label="Minha Conta" active="profile.*" />
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full group flex items-center px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                                    <x-icon name="sign-out-alt" style="duotone" class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-500" />
                                    Sair
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            {{-- Content Wrapper (Navbar + Main) --}}
            {{-- Main Content Area --}}
            <div class="flex flex-col min-w-0 h-screen overflow-hidden">
                <x-layouts.app-navbar />

                <main class="flex-1 min-h-0 min-w-0 overflow-y-auto bg-slate-50 dark:bg-slate-950" role="main" id="app-main-content">
                    <div class="w-full max-w-6xl mx-auto px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
                        @if(session('success'))
                            <div class="mb-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-sm font-medium" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-4 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-sm font-medium" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('info'))
                            <div class="mb-4 p-4 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm font-medium" role="alert">
                                {{ session('info') }}
                            </div>
                        @endif
                        <div class="w-full">
                            {!! $slot !!}
                        </div>
                    </div>
                </main>
            </div> {{-- Closes Content Wrapper (line 99) --}}
        </div> {{-- Closes Main Grid (line 45) --}}

        <x-command-palette />
    </div> {{-- Closes Alpine Scope (line 40) --}}

    @livewireScripts
</body>
</html>
