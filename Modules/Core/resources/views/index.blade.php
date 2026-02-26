<x-layouts.app-sidebar title="Recursos — Oh Pro!">
    <div class="max-w-2xl mx-auto">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <x-icon name="folder-open" style="duotone" class="text-indigo-500" />
                Recursos
            </h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">
                Acesso rápido a notificações e início.
            </p>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @if(\Illuminate\Support\Facades\Route::has('notifications.index'))
                <a href="{{ route('notifications.index') }}" class="block rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                            <x-icon name="bell" style="duotone" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Notificações</h2>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Ver todas as suas notificações.</p>
                </a>
            @endif
            <a href="{{ route('dashboard') }}" class="block rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2 rounded-lg bg-slate-100 dark:bg-slate-700">
                        <x-icon name="home" style="duotone" class="w-6 h-6 text-slate-600 dark:text-slate-300" />
                    </div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Início</h2>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Voltar ao painel principal.</p>
            </a>
        </div>
    </div>
</x-layouts.app-sidebar>
