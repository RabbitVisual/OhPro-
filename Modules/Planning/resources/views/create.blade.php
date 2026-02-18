<x-planning::layouts.master title="Novo plano">
    <div class="p-4 md:p-6 max-w-2xl mx-auto">
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <x-icon name="book-open-reader" style="duotone" />
            Novo plano de aula
        </h1>

        <form action="{{ route('planning.store') }}" method="POST" id="planning-create-form">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="template_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template</label>
                    <select name="template_key" id="template_key" required
                            class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Selecione...</option>
                        @foreach($templates as $t)
                            <option value="{{ $t->key }}" {{ old('template_key') === $t->key ? 'selected' : '' }}>{{ $t->name }}</option>
                        @endforeach
                    </select>
                    @error('template_key')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas (opcional)</label>
                    <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    <x-icon name="check" style="duotone" class="fa-sm" />
                    Criar plano
                </button>
                <a href="{{ route('planning.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
</x-planning::layouts.master>
