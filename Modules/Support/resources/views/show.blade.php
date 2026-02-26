<x-layouts.app-sidebar title="Detalhe do chamado">
    <div class="min-h-screen p-4 md:p-6">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('supports.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1 mb-6 w-fit">
                <x-icon name="arrow-left" class="fa-sm" />
                Voltar para Meus Chamados
            </a>

            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-1">{{ $ticket->subject }}</h1>
                    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <span>{{ ucfirst($ticket->category) }}</span>
                        <span>·</span>
                        <span>{{ $ticket->created_at->translatedFormat('d/m/Y H:i') }}</span>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($ticket->status_color === 'blue') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @elseif($ticket->status_color === 'amber') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                            @elseif($ticket->status_color === 'emerald') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @endif">
                            {{ $ticket->status_label }}
                        </span>
                    </div>
                </div>
                @if(in_array($ticket->status, ['open', 'in_progress'], true))
                    <a href="{{ route('supports.edit', $ticket) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">Editar</a>
                @endif
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden shadow-sm space-y-0">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Sua mensagem</h2>
                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $ticket->message }}</p>
                </div>
                @if($ticket->admin_reply)
                    <div class="p-6 bg-gray-50 dark:bg-gray-900/50">
                        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <x-icon name="headset" style="duotone" class="w-4 h-4" />
                            Resposta do suporte
                            @if($ticket->replied_at)
                                <span class="text-xs font-normal text-gray-400">{{ $ticket->replied_at->translatedFormat('d/m/Y H:i') }}</span>
                            @endif
                        </h2>
                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $ticket->admin_reply }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('supports.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Voltar à lista</a>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
