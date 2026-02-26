{{-- Top navbar: menu button, search, notifications, avatar. Used inside app-sidebar (same Alpine scope: sidebarOpen). --}}
<header class="flex shrink-0 items-center justify-between gap-3 h-16 w-full min-w-0 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 md:px-6">
    <button type="button" @click="sidebarOpen = true" class="p-2 -ml-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg lg:hidden focus:outline-none focus:ring-2 focus:ring-indigo-500 shrink-0" aria-label="Abrir menu">
        <x-icon name="bars" class="w-6 h-6" />
    </button>

    <button type="button" @click="$dispatch('open-command-palette')" class="hidden md:flex items-center flex-1 min-w-0 max-w-md pl-4 pr-3 py-2.5 text-sm text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-colors">
        <x-icon name="search" style="duotone" class="w-4 h-4 mr-3 shrink-0 text-slate-400" />
        <span class="truncate">Buscar (Ctrl+K)</span>
    </button>

    <div class="flex items-center gap-2 shrink-0">
        <livewire:core.notification-center />
        <div class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm" title="{{ auth()->user()->name }}">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>
</header>
