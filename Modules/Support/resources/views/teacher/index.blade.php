<x-layouts.app-sidebar :title="$title ?? 'Suporte'">
    <div class="min-h-screen p-4 md:p-6">
        <livewire:support::ticket-manager />

        <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Perguntas Frequentes (FAQ)</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Em breve você encontrará aqui respostas para as dúvidas mais comuns.</p>
             {{-- Link to FAQ page if created later --}}
        </div>
    </div>
</x-layouts.app-sidebar>
