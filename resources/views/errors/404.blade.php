<x-layouts.guest title="Página não encontrada — Oh Pro!">
    <div class="min-h-screen flex items-center justify-center bg-white dark:bg-slate-950 px-4">
        <div class="text-center max-w-lg">
            <div class="mb-8 relative inline-block">
                <div class="absolute inset-0 bg-indigo-500/20 blur-3xl rounded-full"></div>
                <x-icon name="map-location-dot" style="duotone" class="w-32 h-32 text-indigo-500 relative z-10" />
            </div>

            <h1 class="text-6xl font-display font-bold text-slate-900 dark:text-white mb-4">404</h1>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-4">Página não encontrada</h2>

            <p class="text-slate-600 dark:text-slate-400 mb-8 text-lg">
                Parece que você se perdeu no caminho da escola. A página que você procura não existe ou foi movida.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                    Voltar para o Início
                </a>
                <a href="{{ url()->previous() }}" class="px-6 py-3 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 rounded-xl font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>
