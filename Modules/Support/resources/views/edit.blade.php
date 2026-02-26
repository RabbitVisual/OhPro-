<x-layouts.app-sidebar title="Editar chamado">
    <div class="min-h-screen p-4 md:p-6">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('supports.show', $ticket) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1 mb-6 w-fit">
                <x-icon name="arrow-left" class="fa-sm" />
                Voltar ao chamado
            </a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-4">Editar chamado</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Altere os dados abaixo e salve para atualizar o chamado.</p>
            <form action="{{ route('supports.update', $ticket) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assunto</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject', $ticket->subject) }}" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('subject') border-red-500 dark:border-red-400 @enderror">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 dark:border-red-400 @enderror">{{ old('description', $ticket->message) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Atualizar</button>
                    <a href="{{ route('supports.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app-sidebar>
