<div class="w-full space-y-6">
    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 flex items-center gap-3">
            <x-icon name="check-circle" style="solid" class="w-6 h-6" />
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        @if(!auth()->check())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Seu Nome</label>
                    <input type="text" wire:model="name" class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="João Silva">
                    @error('name') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Seu E-mail</label>
                    <input type="email" wire:model="email" class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="joao@exemplo.com">
                    @error('email') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Assunto</label>
                <input type="text" wire:model="subject" class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Ex: Dúvida sobre pagamento">
                @error('subject') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Categoria</label>
                <select wire:model="category" class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                    <option value="other">Outros</option>
                    <option value="billing">Financeiro / Pagamentos</option>
                    <option value="technical">Suporte Técnico</option>
                    <option value="suggestion">Sugestão</option>
                </select>
                @error('category') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Mensagem</label>
            <textarea wire:model="message" rows="5" class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Descreva sua dúvida ou problema com detalhes..."></textarea>
            @error('message') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
            <x-icon name="paper-plane-top" style="solid" class="w-5 h-5" />
            <span>Enviar Mensagem</span>
        </button>
    </form>
</div>
