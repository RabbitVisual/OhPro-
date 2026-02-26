<x-finance::layouts.master>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Detalhe</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Módulo Finance. Passe o modelo do controller quando o recurso estiver implementado.</p>
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-800/50">
            <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $id ?? 'N/A' }}</p>
        </div>
        <div class="mt-6 flex gap-3">
            <a href="{{ route('finance.edit', $id ?? 1) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Editar</a>
            <a href="{{ route('finance.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Voltar</a>
        </div>
    </div>
</x-finance::layouts.master>
