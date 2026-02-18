<x-layouts.app-sidebar :title="$title ?? 'Tickets de Suporte'">
    <div class="min-h-screen p-4 md:p-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                    Tickets de Suporte
                </h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Gerencie as solicitações dos professores.
                </p>
            </div>
             <div class="flex items-center gap-2">
                <a href="{{ route('panel.admin.tickets.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">Todos</a>
                <a href="{{ route('panel.admin.tickets.index', ['status' => 'open']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ request('status') == 'open' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">Abertos</a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider text-xs font-semibold">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Assunto</th>
                            <th class="px-6 py-4">Usuário</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Criado em</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($tickets as $ticket)
                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">#{{ $ticket->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $ticket->subject }}</div>
                                <div class="text-xs text-gray-500 capitalize">{{ $ticket->category }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-xs text-indigo-600 dark:text-indigo-400 font-bold">
                                        {{ substr($ticket->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $ticket->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' :
                                       ($ticket->status === 'answered' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('panel.admin.tickets.show', $ticket) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                                    Ver / Responder
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <x-icon name="inbox" style="duotone" class="w-8 h-8 mb-3 text-gray-300 dark:text-gray-600" />
                                    <p>Nenhum ticket encontrado.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
