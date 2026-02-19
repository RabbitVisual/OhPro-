<div>
    {{-- Modal --}}
    <div x-data="{ open: @entangle('modalOpen') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog"
         aria-modal="true">

        {{-- Backdrop --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity"
             @click="open = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-slate-800">

                <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/30 sm:mx-0 sm:h-10 sm:w-10">
                            <x-icon name="pen-to-square" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-semibold leading-6 text-slate-900 dark:text-white" id="modal-title">Editar Turma</h3>
                            <div class="mt-2 space-y-4">

                                @if(!$confirmingDeletion)
                                    <div>
                                        <label for="edit-class-name" class="block text-sm font-medium leading-6 text-slate-900 dark:text-slate-300">Nome da Turma</label>
                                        <div class="mt-2">
                                            <input type="text" wire:model="name" id="edit-class-name" class="block w-full rounded-md border-0 py-1.5 text-slate-900 dark:text-white shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-700 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-slate-800 sm:text-sm sm:leading-6">
                                        </div>
                                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="edit-grade" class="block text-sm font-medium leading-6 text-slate-900 dark:text-slate-300">Série/Ano</label>
                                            <div class="mt-2">
                                                <select wire:model="grade_level" id="edit-grade" class="block w-full rounded-md border-0 py-1.5 text-slate-900 dark:text-white shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-slate-800 sm:text-sm sm:leading-6">
                                                    <option value="">Selecione...</option>
                                                    <option value="6º Ano">6º Ano</option>
                                                    <option value="7º Ano">7º Ano</option>
                                                    <option value="8º Ano">8º Ano</option>
                                                    <option value="9º Ano">9º Ano</option>
                                                    <option value="1º Ano EM">1º Ano EM</option>
                                                    <option value="2º Ano EM">2º Ano EM</option>
                                                    <option value="3º Ano EM">3º Ano EM</option>
                                                    <option value="Outro">Outro</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="edit-subject" class="block text-sm font-medium leading-6 text-slate-900 dark:text-slate-300">Disciplina</label>
                                            <div class="mt-2">
                                                <input type="text" wire:model="subject" id="edit-subject" class="block w-full rounded-md border-0 py-1.5 text-slate-900 dark:text-white shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-700 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-slate-800 sm:text-sm sm:leading-6">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="edit-class-color" class="block text-sm font-medium leading-6 text-slate-900 dark:text-slate-300">Cor</label>
                                        <div class="mt-2 flex items-center gap-3">
                                            <input type="color" wire:model="color" id="edit-class-color" class="h-10 w-14 rounded border border-slate-300 dark:border-slate-700 bg-transparent p-1 cursor-pointer">
                                            <span class="text-sm text-slate-500 dark:text-slate-400" x-text="$wire.color"></span>
                                        </div>
                                        @error('color') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                @else
                                    <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <x-icon name="triangle-exclamation" class="h-5 w-5 text-red-400" />
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Tem certeza?</h3>
                                                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                                    <p>Você está prestes a excluir esta turma. Dados como notas, presença e diários vinculados serão perdidos.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 justify-between items-center">
                    <div class="flex flex-row-reverse gap-3 w-full sm:w-auto">
                        @if(!$confirmingDeletion)
                            <button type="button" wire:click="save" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:w-auto transition-all disabled:opacity-50" wire:loading.attr="disabled">
                                Salvar Alterações
                            </button>
                            <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-slate-800 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-slate-300 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 sm:mt-0 sm:w-auto transition-all">Cancelar</button>
                        @else
                            <button type="button" wire:click="delete" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-all disabled:opacity-50" wire:loading.attr="disabled">
                                <span wire:loading.remove>Sim, Excluir Turma</span>
                                <span wire:loading>Excluindo...</span>
                            </button>
                            <button type="button" wire:click="$set('confirmingDeletion', false)" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-slate-800 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-slate-300 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 sm:mt-0 sm:w-auto transition-all">Cancelar</button>
                        @endif
                    </div>

                    @if(!$confirmingDeletion)
                    <div class="mt-3 sm:mt-0">
                        <button type="button" wire:click="confirmDeletion" class="text-xs text-red-500 hover:text-red-700 underline">
                            Excluir Turma
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
