<div>
    {{-- Header with Action --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Meus Tickets</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Acompanhe suas solicitações de suporte.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
            <x-icon name="plus" class="w-4 h-4" />
            Novo Ticket
        </button>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800 flex items-center gap-2">
            <x-icon name="check-circle" class="w-5 h-5" />
            {{ session('success') }}
        </div>
    @endif

    {{-- Ticket List --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
        <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($tickets as $ticket)
            <li class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors cursor-pointer" wire:click="show({{ $ticket->id }})">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full
                                {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' :
                                   ($ticket->status === 'answered' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400') }}">
                                <x-icon name="{{ $ticket->status === 'answered' ? 'check' : ($ticket->status === 'open' ? 'clock' : 'archive') }}" style="duotone" class="h-5 w-5" />
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $ticket->subject }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 flex items-center gap-2">
                                <span>#{{ $ticket->id }}</span>
                                <span>&bull;</span>
                                <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                <span>&bull;</span>
                                <span class="capitalize">{{ $ticket->category }}</span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' :
                               ($ticket->status === 'answered' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                            {{ $ticket->status_label }}
                        </span>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                <x-icon name="ticket" style="duotone" class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" />
                <p>Nenhum ticket encontrado.</p>
                <button wire:click="create" class="mt-2 text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:underline">
                    Criar meu primeiro ticket
                </button>
            </li>
            @endforelse
        </ul>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
            {{ $tickets->links() }}
        </div>
    </div>

    {{-- Create Modal --}}
    @if($showCreateModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm" x-transition>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Novo Ticket</h3>
                <button wire:click="$set('showCreateModal', false)" class="text-gray-400 hover:text-gray-500">
                    <x-icon name="times" class="w-5 h-5" />
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assunto</label>
                    <input type="text" wire:model="subject" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('subject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoria</label>
                    <select wire:model="category" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="billing">Cobrança / Financeiro</option>
                        <option value="technical">Problema Técnico</option>
                        <option value="suggestion">Sugestão</option>
                        <option value="other">Outro</option>
                    </select>
                    @error('category') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mensagem</label>
                    <textarea wire:model="message" rows="4" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    @error('message') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30 flex justify-end gap-3">
                <button wire:click="$set('showCreateModal', false)" class="px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Cancelar
                </button>
                <button wire:click="store" class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">
                    Enviar Ticket
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Detail Modal --}}
    @if($showDetailModal && $selectedTicket)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm" x-transition>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $selectedTicket->subject }}</h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 uppercase">
                            {{ $selectedTicket->category }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $selectedTicket->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <button wire:click="closeDetail" class="text-gray-400 hover:text-gray-500">
                    <x-icon name="times" class="w-5 h-5" />
                </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1 space-y-6">
                {{-- User Message --}}
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-br-2xl rounded-bl-2xl rounded-tr-2xl p-4">
                            <p class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $selectedTicket->message }}</p>
                        </div>
                    </div>
                </div>

                {{-- Admin Reply --}}
                @if($selectedTicket->admin_reply)
                <div class="flex gap-4 flex-row-reverse">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold">
                            S
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-br-2xl rounded-bl-2xl rounded-tl-2xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400">Suporte</span>
                                <span class="text-xs text-emerald-600 dark:text-emerald-500">{{ $selectedTicket->replied_at?->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $selectedTicket->admin_reply }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="flex justify-center py-4">
                    <span class="text-xs text-gray-400 flex items-center gap-1">
                        <x-icon name="clock" class="w-3 h-3" />
                        Aguardando resposta do suporte...
                    </span>
                </div>
                @endif
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30 text-right">
                <button wire:click="closeDetail" class="px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Fechar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
