<x-layouts.app-sidebar title="Detalhe do chamado">
    <div class="min-h-screen p-4 md:p-6">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('supports.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1 mb-6 w-fit">
                <x-icon name="arrow-left" class="fa-sm" />
                Voltar para Meus Chamados
            </a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-4">Detalhe do chamado</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Exibição do chamado. Passe o modelo do controller quando o recurso estiver implementado.</p>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $id ?? 'N/A' }}</p>
            </div>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('supports.edit', $id ?? 1) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Editar</a>
                <a href="{{ route('supports.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Voltar</a>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
