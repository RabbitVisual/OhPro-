<x-layouts.app-sidebar :title="$title ?? 'Detalhes do Ticket'">
    <div class="min-h-screen p-4 md:p-6 flex justify-center">
        <div class="w-full max-w-3xl space-y-6">
            {{-- Header --}}
             <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('panel.admin.tickets.index') }}" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <x-icon name="arrow-left" class="w-5 h-5" />
                    </a>
                    <div>
                        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white">
                            Ticket #{{ $ticket->id }}
                        </h1>
                        <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                             <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                             <span>&bull;</span>
                             <span class="capitalize">{{ $ticket->category }}</span>
                        </span>
                    </div>
                </div>
                 <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' :
                       ($ticket->status === 'answered' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                    {{ $ticket->status_label }}
                </span>
            </div>

            {{-- User Message --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 p-6">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                        {{ substr($ticket->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ $ticket->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $ticket->user->email }}</div>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $ticket->subject }}</h3>
                <div class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $ticket->message }}</div>
            </div>

            {{-- Reply Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 p-6 border-l-4 border-l-indigo-500">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Responder</h3>

                <form action="{{ route('panel.admin.tickets.reply', $ticket) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="block w-full md:w-1/3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Aberto</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                            <option value="answered" {{ $ticket->status == 'answered' ? 'selected' : '' }}>Respondido</option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Fechado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mensagem de Resposta</label>
                        <textarea name="reply" rows="6" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escreva sua resposta aqui...">{{ old('reply', $ticket->admin_reply) }}</textarea>
                        @error('reply') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                            <x-icon name="paper-plane" class="w-4 h-4" />
                            Enviar Resposta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
