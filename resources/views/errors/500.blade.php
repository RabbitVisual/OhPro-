<x-layouts.guest title="Erro no Servidor — Oh Pro!">
    <div class="min-h-screen flex items-center justify-center bg-white dark:bg-slate-950 px-4">
        <div class="text-center max-w-lg">
            <div class="mb-8 relative inline-block">
                <div class="absolute inset-0 bg-amber-500/20 blur-3xl rounded-full"></div>
                <x-icon name="plug-circle-exclamation" style="duotone" class="w-32 h-32 text-amber-500 relative z-10" />
            </div>

            <h1 class="text-6xl font-display font-bold text-slate-900 dark:text-white mb-4">500</h1>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-4">Erro no Servidor</h2>

            <p class="text-slate-600 dark:text-slate-400 mb-8 text-lg">
                Ops! Algo deu errado do nosso lado. Nossos engenheiros já foram notificados (provavelmente).
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                    Tentar Novamente
                </button>
                <a href="{{ url('/') }}" class="px-6 py-3 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 rounded-xl font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Voltar para o Início
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>
