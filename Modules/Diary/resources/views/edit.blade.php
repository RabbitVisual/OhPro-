<x-diary::layouts.master title="Editar registro">
    <div class="w-full">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight">Editar registro de aula</h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">Implemente o método update() no controller e defina os campos quando necessário.</p>
        </header>
        <form action="{{ route('diary.update', $id ?? 1) }}" method="POST" class="max-w-xl space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Observações</label>
                <textarea name="notes" id="notes" rows="4" class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('notes') }}</textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Atualizar</button>
                <a href="{{ route('diary.index') }}" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600">Cancelar</a>
            </div>
        </form>
    </div>
</x-diary::layouts.master>
