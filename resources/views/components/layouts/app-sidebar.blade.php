<x-layouts.app :title="$title ?? ''">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">

        {{-- Mobile sidebar backdrop --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

        {{-- Sidebar --}}
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl lg:shadow-none flex flex-col">
            {{-- Logo --}}
            <div class="flex items-center justify-center h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-display font-bold text-xl text-slate-900 dark:text-white hover:opacity-90 transition-opacity">
                    <x-icon name="chalkboard-user" style="duotone" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                    <span>Oh <span class="text-indigo-600 dark:text-indigo-400">Pro!</span></span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto custom-scrollbar">

                {{-- Teacher Links --}}
                @role('teacher')
                    <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Professor</p>
                    <x-nav-link route="workspace.index" icon="chalkboard" label="Workspace" active="workspace.*" />
                    <x-nav-link route="planning.index" icon="calendar-alt" label="Planejamento" active="planning.*" />
                    <x-nav-link route="notebook.index" icon="book" label="Caderno" active="notebook.*" />
                    <x-nav-link route="diary.index" icon="pen-to-square" label="Diário" active="diary.*" />
                    <x-nav-link route="library.index" icon="books" label="Biblioteca" active="library.*" />
                @endrole

                {{-- Manager Links --}}
                @role('manager')
                    <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Gestão</p>
                    <x-nav-link route="dashboard" icon="chart-pie" label="Dashboard" active="dashboard" />
                @endrole

                {{-- Admin Links --}}
                @role('admin')
                    <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Administração</p>
                    <x-nav-link route="panel.admin" icon="tachometer-alt" label="Dashboard" active="panel.admin" />
                    <x-nav-link route="panel.admin.users.index" icon="users" label="Usuários" active="panel.admin.users.*" />
                    <x-nav-link route="panel.admin.plans.index" icon="tags" label="Planos" active="panel.admin.plans.*" />
                    <x-nav-link route="panel.admin.subscriptions" icon="credit-card" label="Assinaturas" active="panel.admin.subscriptions*" />
                    <x-nav-link route="panel.admin.tickets.index" icon="ticket-alt" label="Tickets" active="panel.admin.tickets.*" />
                    <x-nav-link route="panel.admin.health" icon="heartbeat" label="Saúde do Sistema" active="panel.admin.health" />
                @endrole

                {{-- Support (Teacher) --}}
                @role('teacher')
                    <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Ajuda</p>
                    <x-nav-link route="support.index" icon="life-ring" label="Suporte" active="support.*" />
                @endrole

                {{-- User & Logout --}}
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

        {{-- Main Content Wrapper --}}
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            {{-- Top Navbar --}}
            <header class="flex items-center justify-between gap-4 h-16 shrink-0 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 md:px-6">
                <button type="button" @click="sidebarOpen = true" class="p-2 -ml-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg lg:hidden focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="Abrir menu">
                    <x-icon name="bars" class="w-6 h-6" />
                </button>

                {{-- Command Palette --}}
                <button type="button" @click="$dispatch('open-command-palette')" class="hidden md:flex items-center flex-1 max-w-md pl-4 pr-3 py-2.5 text-sm text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-colors">
                    <x-icon name="search" style="duotone" class="w-4 h-4 mr-3 text-slate-400" />
                    <span>Buscar (Ctrl+K)</span>
                </button>

                <div class="flex items-center gap-3">
                    <livewire:core.notification-center />
                    <div class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm shrink-0" title="{{ auth()->user()->name }}">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 dark:bg-slate-950 p-4 md:p-6">
                {{ $slot }}
            </main>
        </div>

        <x-command-palette />
    </div>
</x-layouts.app>
