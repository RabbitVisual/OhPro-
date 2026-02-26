<x-marketplace::layouts.master>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Criar</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Módulo Marketplace. Implemente o método store() no controller e defina o modelo quando necessário.</p>
        <form action="{{ route('marketplace.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Salvar</button>
                <a href="{{ route('marketplace.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Cancelar</a>
            </div>
        </form>
    </div>
</x-marketplace::layouts.master>
