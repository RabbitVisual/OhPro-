<x-layouts.app :title="$title ?? ''">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-gray-100 dark:bg-gray-900">

        {{-- Mobile sidebar backdrop --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden" @click="sidebarOpen = false"></div>

        {{-- Sidebar --}}
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-lg lg:shadow-none flex flex-col">
            {{-- Logo --}}
            <div class="flex items-center justify-center h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-display font-bold text-xl text-gray-900 dark:text-white">
                    <x-icon name="layer-group" style="duotone" class="text-indigo-600" />
                    <span>Vertex<span class="text-indigo-600">Oh!</span></span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto custom-scrollbar">

                {{-- Teacher Links --}}
                @role('teacher')
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-2">Professor</p>
                    <x-nav-link route="workspace.index" icon="chalkboard" label="Workspace" active="workspace.*" />
                    <x-nav-link route="planning.index" icon="calendar-alt" label="Planejamento" active="planning.*" />
                    <x-nav-link route="notebook.index" icon="book" label="Caderno" active="notebook.*" />
                    <x-nav-link route="diary.index" icon="edit" label="Diário" active="diary.*" />
                    <x-nav-link route="library.index" icon="books" label="Biblioteca" active="library.*" />
                @endrole

                {{-- Manager Links --}}
                @role('manager')
                     <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-4">Gestão</p>
                     {{-- Create Manager Dashboard route if not exists, for now point to home or placeholder --}}
                     <x-nav-link route="dashboard" icon="chart-pie" label="Dashboard" active="dashboard" />
                @endrole

                {{-- Admin Links --}}
                @role('admin')
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-4">Administração</p>
                    <x-nav-link route="panel.admin" icon="tachometer-alt" label="Dashboard" active="panel.admin" />
                    <x-nav-link route="panel.admin.users.index" icon="users" label="Usuários" active="panel.admin.users.*" />
                    <x-nav-link route="panel.admin.plans.index" icon="tags" label="Planos" active="panel.admin.plans.*" />
                    <x-nav-link route="panel.admin.subscriptions" icon="credit-card" label="Assinaturas" active="panel.admin.subscriptions*" />
                    <x-nav-link route="panel.admin.tickets.index" icon="ticket-alt" label="Tickets" active="panel.admin.tickets.*" />
                    <x-nav-link route="panel.admin.health" icon="heartbeat" label="Saúde do Sistema" active="panel.admin.health" />
                @endrole

                 {{-- Support Links (Teacher & Generic) --}}
                 <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-4">Ajuda</p>
                 @role('teacher')
                    <x-nav-link route="support.index" icon="life-ring" label="Suporte" active="support.*" />
                 @endrole

                 {{-- User Config --}}
                 <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                    <x-nav-link route="profile.edit" icon="user-cog" label="Minha Conta" active="profile.*" />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <x-icon name="sign-out-alt" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" />
                            Sair
                        </button>
                    </form>
                 </div>
            </nav>
        </div>

        {{-- Main Content Wrapper --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Navbar --}}
            <header class="flex items-center justify-between h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 md:px-6">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                    <x-icon name="bars" class="w-6 h-6" />
                </button>

                {{-- Command Palette Trigger --}}
                <button @click="$dispatch('open-command-palette')" class="hidden md:flex items-center w-64 pl-4 pr-3 py-2 text-sm text-gray-500 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none hover:border-gray-300 dark:hover:border-gray-500 transition-colors">
                    <x-icon name="search" class="w-4 h-4 mr-3" />
                    <span>Buscar (Ctrl+K)</span>
                </button>

                 <div class="flex items-center gap-4">
                    {{-- Notifications Bell Placeholder --}}
                    <button class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <x-icon name="bell" class="w-5 h-5" />
                        {{-- <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span> --}}
                    </button>

                    <div class="flex items-center gap-2">
                         <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                 </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 md:p-6">
                {{ $slot }}
            </main>
        </div>

        <x-command-palette />
    </div>
</x-layouts.app>
