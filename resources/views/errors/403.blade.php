<x-layouts.guest title="Acesso Negado — Oh Pro!">
    <div class="min-h-screen flex items-center justify-center bg-white dark:bg-slate-950 px-4">
        <div class="text-center max-w-lg">
            <div class="mb-8 relative inline-block">
                <div class="absolute inset-0 bg-rose-500/20 blur-3xl rounded-full"></div>
                <x-icon name="ban" style="duotone" class="w-32 h-32 text-rose-500 relative z-10" />
            </div>

            <h1 class="text-6xl font-display font-bold text-slate-900 dark:text-white mb-4">403</h1>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-4">Acesso Negado</h2>

            <p class="text-slate-600 dark:text-slate-400 mb-8 text-lg">
                Você não tem permissão para acessar esta área. Se acha que isso é um erro, contate o administrador.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                    Voltar para o Início
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>
