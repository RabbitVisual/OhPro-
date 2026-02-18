<x-planning::layouts.master title="Novo plano">
    <div class="p-4 md:p-6 max-w-2xl mx-auto" x-data="{
        aiModalOpen: false,
        aiSubject: '',
        aiBnccSkill: '',
        aiError: null,
        async submitAi() {
            this.aiError = null;
            window.dispatchEvent(new CustomEvent('start-loading', { detail: { message: 'Jules está redigindo seu plano de aula...', icon: 'book-open-reader' } }));
            try {
                const res = await fetch('{{ route('planning.generate-with-ai') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ subject: this.aiSubject, bncc_skill: this.aiBnccSkill, _token: '{{ csrf_token() }}' })
                });
                const data = await res.json().catch(() => ({}));
                if (res.ok && data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }
                this.aiError = data.message || 'Não foi possível gerar o plano. Tente novamente.';
            } catch (e) {
                this.aiError = 'Erro de conexão. Tente novamente.';
            } finally {
                window.dispatchEvent(new CustomEvent('stop-loading'));
            }
        }
    }">
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <x-icon name="book-open-reader" style="duotone" />
            Novo plano de aula
        </h1>

        <div class="mb-6 flex flex-wrap gap-2">
            <button type="button" @click="aiModalOpen = true; aiError = null"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 dark:bg-purple-500 dark:hover:bg-purple-600">
                <x-icon name="laptop-code" style="duotone" class="fa-sm" />
                Gerar com IA
            </button>
        </div>

        <template x-teleport="body">
            <div x-show="aiModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @keydown.escape.window="aiModalOpen = false">
                <div x-show="aiModalOpen" x-transition
                     @click.outside="aiModalOpen = false"
                     class="w-full max-w-lg rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl p-6">
                    <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <x-icon name="laptop-code" style="duotone" class="fa-sm" />
                        Gerar plano com IA
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Informe a disciplina e a competência BNCC. O assistente gerará um plano no formato Detalhado.</p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disciplina</label>
                            <input type="text" x-model="aiSubject" placeholder="Ex.: Matemática, 6º ano"
                                   class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Competência / Habilidade BNCC</label>
                            <textarea x-model="aiBnccSkill" rows="3" placeholder="Cole ou descreva a competência BNCC"
                                      class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm"></textarea>
                        </div>
                        <p x-show="aiError" x-text="aiError" class="text-sm text-red-600 dark:text-red-400"></p>
                    </div>
                    <div class="mt-6 flex gap-2 justify-end">
                        <button type="button" @click="aiModalOpen = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancelar</button>
                        <button type="button" @click="submitAi()"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700">
                            <x-icon name="laptop-code" style="duotone" class="fa-sm" />
                            Gerar plano
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <form action="{{ route('planning.store') }}" method="POST" id="planning-create-form">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="template_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template</label>
                    <select name="template_key" id="template_key" required
                            class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Selecione...</option>
                        @foreach($templates as $t)
                            <option value="{{ $t->key }}" {{ old('template_key') === $t->key ? 'selected' : '' }}>{{ $t->name }}</option>
                        @endforeach
                    </select>
                    @error('template_key')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas (opcional)</label>
                    <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    <x-icon name="check" style="duotone" class="fa-sm" />
                    Criar plano
                </button>
                <a href="{{ route('planning.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
</x-planning::layouts.master>
