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

            @if($tickets->isEmpty())
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
            @else
                <!-- Ticket List -->
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/50 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assunto</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoria</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($tickets as $ticket)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                        <td class="px-4 py-3">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ Str::limit($ticket->subject, 50) }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                            {{ ucfirst($ticket->category) }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($ticket->status_color === 'blue') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                                @elseif($ticket->status_color === 'amber') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                                                @elseif($ticket->status_color === 'emerald') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @endif">
                                                {{ $ticket->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->created_at->translatedFormat('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('supports.show', $ticket) }}" class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                        {{ $tickets->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app-sidebar>
