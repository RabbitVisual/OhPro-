<section id="pricing" class="py-24 bg-white dark:bg-slate-950 font-sans scroll-mt-24" x-data="{ annual: true }">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-3xl md:text-5xl font-display font-bold text-slate-900 dark:text-white mb-6">
                Planos simples para <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600">cada etapa</span>
            </h2>
            <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">
                Comece gratuitamente e evolua conforme suas necessidades.
            </p>

            {{-- Toggle --}}
            <div class="inline-flex items-center p-1 bg-slate-100 dark:bg-slate-900 rounded-full border border-slate-200 dark:border-slate-800 relative">
                <button @click="annual = false"
                    :class="!annual ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                    class="px-6 py-2 rounded-full text-sm font-medium transition-all duration-200">
                    Mensal
                </button>
                <button @click="annual = true"
                    :class="annual ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                    class="px-6 py-2 rounded-full text-sm font-medium transition-all duration-200 relative">
                    Anual
                    <span class="absolute -top-3 -right-3 px-2 py-0.5 bg-emerald-500 text-white text-[10px] uppercase font-bold tracking-wider rounded-full transform rotate-12 shadow-sm border border-emerald-400">
                        -15% OFF
                    </span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch max-w-5xl mx-auto">
            {{-- Free --}}
            <div class="flex flex-col rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 p-8 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                <div class="mb-4">
                    <span class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Gratuito</span>
                </div>
                <div class="mb-6 flex items-baseline">
                    <span class="text-4xl font-bold text-slate-900 dark:text-white">R$ 0</span>
                    <span class="text-slate-500 dark:text-slate-400 ml-2">/para sempre</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">Para professores que estão começando e querem organizar suas primeiras turmas.</p>
                <a href="{{ route('register') }}" class="block w-full py-3 px-6 rounded-xl font-bold text-center border-2 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600 transition-colors mb-8">
                    Começar Grátis
                </a>
                <ul class="space-y-4 text-sm text-slate-600 dark:text-slate-400">
                    <li class="flex items-start gap-3">
                        <x-icon name="check" class="w-5 h-5 text-emerald-500 shrink-0" />
                        <span>Até 3 Turmas</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-icon name="check" class="w-5 h-5 text-emerald-500 shrink-0" />
                        <span>5 Planos com IA /mês</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-icon name="check" class="w-5 h-5 text-emerald-500 shrink-0" />
                        <span>Diário de Classe Básico</span>
                    </li>
                </ul>
            </div>

            {{-- Pro --}}
            <div class="flex flex-col rounded-3xl border-2 border-indigo-500 bg-white dark:bg-slate-900 p-8 relative shadow-2xl shadow-indigo-500/10 scale-[1.02] md:scale-110 z-10">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-indigo-600 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">
                    Mais Popular
                </div>
                <div class="mb-4">
                    <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Profissional</span>
                </div>
                <div class="mb-6 flex items-baseline">
                    <span class="text-5xl font-bold text-slate-900 dark:text-white" x-text="annual ? 'R$ 29' : 'R$ 39'">R$ 29</span>
                    <span class="text-slate-500 dark:text-slate-400 ml-2">/mês</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6" x-show="annual">
                    Faturado anualmente (R$ 348). <span class="text-emerald-500 font-bold">2 meses grátis.</span>
                </p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6" x-show="!annual">
                    Faturado mensalmente. Cancele quando quiser.
                </p>
                <a href="{{ route('register', ['plan' => 'pro']) }}" class="block w-full py-4 px-6 rounded-xl font-bold text-center bg-indigo-600 text-white hover:bg-indigo-700 transition-colors mb-8 shadow-lg shadow-indigo-500/30">
                    Assinar Pro Agora
                </a>
                <ul class="space-y-4 text-sm text-slate-600 dark:text-slate-400">
                    <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-indigo-600 flex-shrink-0" />
                        <span>Até 20 Turmas</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-indigo-600 flex-shrink-0" />
                        <span>50 Planos com IA /mês</span>
                    </li>
                     <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-indigo-600 flex-shrink-0" />
                        <span>Exportação de Relatórios</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-indigo-600 flex-shrink-0" />
                        <span>3 Escolas</span>
                    </li>
                </ul>
            </div>

            <!-- School Plan -->
            <div class="p-8 rounded-[2rem] bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex flex-col">
                <div class="mb-4">
                    <span class="px-3 py-1 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-wider">
                        Escola
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Personalizado</h3>
                <div class="flex items-baseline gap-1 mb-6">
                    <span class="text-4xl font-bold text-slate-900 dark:text-white">Sob Consulta</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">Para coordenação pedagógica e gestão de múltiplas turmas e professores.</p>
                <a href="{{ route('contact') }}?subject=sales" class="block w-full py-3 px-6 rounded-xl font-bold text-center border-2 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600 transition-colors mb-8">
                    Falar com Vendas
                </a>
                <ul class="space-y-4 text-sm text-slate-600 dark:text-slate-400">
                    <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-slate-400 flex-shrink-0" />
                        <span>Painel do Coordenador</span>
                    </li>
                     <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-slate-400 flex-shrink-0" />
                        <span>Gestão de Professores</span>
                    </li>
                     <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-slate-400 flex-shrink-0" />
                        <span>Logs de Auditoria</span>
                    </li>
                     <li class="flex items-center gap-3">
                        <x-icon name="check" class="text-slate-400 flex-shrink-0" />
                        <span>SLA Garantido</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
