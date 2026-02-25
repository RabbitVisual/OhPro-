<x-layouts.app-sidebar title="Meus Chamados de Suporte">
    <div class="min-h-screen p-4 md:p-6">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="ticket" style="duotone" class="text-indigo-500" />
                        Chamados de Suporte
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Acompanhe o status e histórico de suas solicitações ao nosso atendimento.
                    </p>
                </div>
                <div>
                    <a href="{{ route('supports.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-indigo-500/20">
                        <x-icon name="plus" class="fa-sm" />
                        Abrir Novo Chamado
                    </a>
                </div>
            </div>

            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/50 rounded-2xl p-12 text-center shadow-sm">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 mb-6">
                    <x-icon name="headset" style="duotone" class="w-10 h-10" />
                </div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Nenhum chamado encontrado!</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                    Você ainda não abriu nenhuma solicitação de suporte. Caso tenha alguma dúvida ou problema, clique no botão abaixo ou acesse nossa página de FAQ.
                </p>
                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('supports.create') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-lg shadow-indigo-500/20">
                        Abrir Novo Chamado
                    </a>
                    <a href="{{ route('support.index') }}" class="px-6 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Ver FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
