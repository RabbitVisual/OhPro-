<div>
    <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
        <x-icon name="timeline" style="duotone" />
        Portfólio — {{ $this->student->name }}
    </h1>
    <p class="text-gray-500 dark:text-gray-400 mb-6 font-sans">Linha do tempo pedagógica do aluno.</p>

    <div class="flex flex-wrap gap-3 mb-8">
        <button type="button" wire:click="$set('showAddForm', true)"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
            <x-icon name="plus" style="duotone" class="fa-sm" />
            Nova observação
        </button>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="openGuestLinkModal" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="share-nodes" style="duotone" class="fa-sm" />
                Portal dos Pais
            </button>

            <label for="report-cycle" class="text-sm text-gray-600 dark:text-gray-400">Ciclo:</label>
            <select id="report-cycle" wire:model="reportCycle" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm px-3 py-2">
                @for ($c = 1; $c <= 4; $c++)
                <option value="{{ $c }}">{{ $c }}</option>
                @endfor
            </select>
            <button type="button" wire:click="generateAiReport" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="wand-magic-sparkles" style="duotone" class="fa-sm" />
                Gerar relatório com IA
            </button>
        </div>
    </div>

    {{-- Guest Link Modal --}}
    @if($showGuestLinkModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showGuestLinkModal', false)"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Acesso para Pais/Responsáveis
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Gere um link seguro para que os responsáveis acompanhem o desempenho do aluno. O link expira em 30 dias.
                                </p>
                            </div>

                            @if($guestLink)
                                <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <label class="block text-xs font-medium text-gray-500 uppercase">Link Ativo (Expira em {{ $guestTokenExpiry }})</label>
                                    <div class="mt-1 flex gap-2">
                                        <input type="text" readonly value="{{ $guestLink }}" class="block w-full text-sm rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-0">
                                         <button type="button" onclick="navigator.clipboard.writeText('{{ $guestLink }}')" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded">
                                            <x-icon name="copy" class="w-4 h-4" />
                                        </button>
                                    </div>
                                    <button wire:click="revokeGuestLink" class="mt-2 text-xs text-red-600 hover:text-red-700 underline">Revogar acesso</button>
                                </div>
                            @else
                                <div class="mt-4">
                                    <button wire:click="generateGuestLink" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        <x-icon name="link" class="w-4 h-4" />
                                        Gerar Novo Link
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" wire:click="$set('showGuestLinkModal', false)">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showAddForm)
    <div class="mb-8 p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4">Nova observação</h2>
        <form wire:submit="addObservation" class="space-y-4">
            <div>
                <label for="obs-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título</label>
                <input type="text" id="obs-title" wire:model="newTitle" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                @error('newTitle') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="obs-content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                <textarea id="obs-content" wire:model="newContent" rows="3" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
            </div>
            <div>
                <label for="obs-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data/hora</label>
                <input type="datetime-local" id="obs-date" wire:model="newOccurredAt" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                @error('newOccurredAt') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700">Salvar</button>
                <button type="button" wire:click="$set('showAddForm', false)" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">Cancelar</button>
            </div>
        </form>
    </div>
    @endif

    @if($aiReport)
    <div class="mb-8 p-6 rounded-xl border border-indigo-200 dark:border-indigo-800 bg-indigo-50/50 dark:bg-indigo-900/20">
        <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-2">Relatório de evolução pedagógica (IA)</h2>
        <p class="font-sans text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $aiReport }}</p>
    </div>
    @endif

    <div class="relative">
        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></div>
        <ul class="space-y-6">
            @forelse($this->entries as $entry)
            <li class="relative pl-12">
                <span class="absolute left-0 flex h-8 w-8 items-center justify-center rounded-full bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400">
                    @if($entry->type === 'observation')
                    <x-icon name="note-sticky" style="duotone" class="fa-sm" />
                    @elseif($entry->type === 'attendance_alert')
                    <x-icon name="user-xmark" style="duotone" class="fa-sm" />
                    @elseif($entry->type === 'grade_change')
                    <x-icon name="chart-line" style="duotone" class="fa-sm" />
                    @elseif($entry->type === 'achievement')
                    <x-icon name="trophy" style="duotone" class="fa-sm" />
                    @else
                    <x-icon name="circle" style="duotone" class="fa-sm" />
                    @endif
                </span>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 font-sans">{{ $entry->occurred_at->format('d/m/Y H:i') }}@if($entry->schoolClass) · {{ $entry->schoolClass->name }}@endif</p>
                    <h3 class="font-display font-bold text-gray-900 dark:text-white mt-1">{{ $entry->title ?? ucfirst($entry->type) }}</h3>
                    @if($entry->content)
                    <p class="mt-2 font-sans text-gray-700 dark:text-gray-300 text-sm">{{ $entry->content }}</p>
                    @endif
                    @if($entry->libraryFile)
                    <a href="{{ route('library.download', $entry->libraryFile) }}" class="inline-flex items-center gap-1 mt-2 text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        <x-icon name="image" style="duotone" class="fa-sm" />
                        Ver anexo
                    </a>
                    @endif
                </div>
            </li>
            @empty
            <li class="pl-12 text-gray-500 dark:text-gray-400 font-sans">Nenhum registro na timeline. Adicione uma observação acima.</li>
            @endforelse
        </ul>
    </div>
</div>
