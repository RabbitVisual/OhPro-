<x-notebook::layouts.master title="Detalhe do caderno">
    <div class="w-full">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight">Detalhe do caderno</h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">Exibição do item. Passe o modelo do controller quando o recurso estiver implementado.</p>
        </header>
        <div class="rounded-xl border border-slate-200 dark:border-slate-700 p-6 bg-slate-50 dark:bg-slate-800/50">
            <p class="text-sm text-slate-500 dark:text-slate-400">ID: {{ $id ?? 'N/A' }}</p>
        </div>
        <div class="mt-6 flex gap-3">
            <a href="{{ route('notebook.edit', $id ?? 1) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Editar</a>
            <a href="{{ route('notebook.index') }}" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600">Voltar</a>
        </div>
    </div>
</x-notebook::layouts.master>
