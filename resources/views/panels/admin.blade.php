<x-layouts.app :title="$title ?? 'Painel Admin'">
    <div class="min-h-screen p-4 md:p-6">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Painel Admin</h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Área reservada a administradores.</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('panel.admin.subscriptions') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700">
                    <x-icon name="credit-card" style="duotone" class="fa-sm" />
                    Ver assinaturas
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
