<x-layouts.app-sidebar title="Novo Chamado de Suporte">
    <div class="min-h-screen p-4 md:p-6" x-data="{
        category: 'duvida',
        urgency: 'baixa',
        fileName: ''
    }">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('supports.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1 mb-4 w-fit">
                    <x-icon name="arrow-left" class="fa-sm" />
                    Voltar para Meus Chamados
                </a>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="pencil" style="duotone" class="text-indigo-500" />
                    Abrir Novo Chamado
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Preencha os detalhes abaixo para que possamos ajudar você da melhor forma.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 md:p-8 shadow-sm">
                <!-- Livewire Component placeholder. Replace with actual Livewire if exists. -->
                <form action="{{ route('supports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Categoria -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Qual o tipo da solicitação?</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="category" value="duvida" x-model="category" class="peer sr-only">
                                    <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-900/50 peer-checked:border-indigo-500 peer-checked:ring-1 peer-checked:ring-indigo-500 transition-all flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 flex items-center justify-center">
                                            <x-icon name="circle-question" class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Dúvida</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="category" value="problema" x-model="category" class="peer sr-only">
                                    <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-900/50 peer-checked:border-rose-500 peer-checked:ring-1 peer-checked:ring-rose-500 transition-all flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-900/30 text-rose-500 flex items-center justify-center">
                                            <x-icon name="triangle-exclamation" class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Problema</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="category" value="sugestao" x-model="category" class="peer sr-only">
                                    <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-900/50 peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 transition-all flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-500 flex items-center justify-center">
                                            <x-icon name="lightbulb" class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Sugestão</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="category" value="pagamento" x-model="category" class="peer sr-only">
                                    <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-900/50 peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500 transition-all flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-500 flex items-center justify-center">
                                            <x-icon name="credit-card" class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Pagamento</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Urgência -->
                        <div x-show="category === 'problema'" x-transition>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nível de Urgência</label>
                            <select name="urgency" x-model="urgency" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3">
                                <option value="baixa">Baixa (Pode esperar)</option>
                                <option value="media">Média (Atrapalha minha rotina)</option>
                                <option value="alta">Alta (Impedindo o acesso/uso total)</option>
                            </select>
                            <p class="mt-2 text-xs text-gray-500">Nosso tempo de resposta varia de acordo com o nível selecionado.</p>
                        </div>
                    </div>

                    <!-- Assunto -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assunto Resumido</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 placeholder-gray-400 @error('subject') border-red-500 dark:border-red-400 @enderror" placeholder="Ex: Erro ao importar alunos no diário" required>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Detalhes da Solicitação</label>
                        <textarea name="description" id="description" rows="5" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 placeholder-gray-400 resize-none @error('description') border-red-500 dark:border-red-400 @enderror" placeholder="Descreva o que aconteceu em detalhes. Se for um problema, conte-nos os passos para reproduzi-lo..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Anexos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Anexos (Opcional)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <x-icon name="cloud-arrow-up" class="w-8 h-8 mb-3 text-gray-400" />
                                    <p class="mb-1 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold" x-text="fileName ? fileName : 'Clique para enviar'"></span><span x-show="!fileName"> ou arraste o arquivo até aqui</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-show="!fileName">PNG, JPG ou PDF (Max. 5MB)</p>
                                </div>
                                <input id="dropzone-file" type="file" name="attachment" class="hidden" accept=".jpg,.jpeg,.png,.pdf" @change="fileName = $event.target.files[0]?.name" />
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                        <a href="{{ route('supports.index') }}" class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                            <x-icon name="paper-plane-top" class="fa-sm" />
                            Enviar Solicitação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
