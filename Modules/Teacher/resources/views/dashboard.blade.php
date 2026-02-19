<x-layouts.app-sidebar title="Dashboard — Oh Pro!">
    <div class="max-w-7xl mx-auto p-6 space-y-6"
         x-data="{
             tour: false,
             step: 1,
             init() {
                 if (!localStorage.getItem('tour_completed')) {
                     this.tour = true;
                 }
             },
             next() {
                 this.step++;
                 if (this.step > 3) {
                     this.finish();
                 }
             },
             finish() {
                 this.tour = false;
                 localStorage.setItem('tour_completed', 'true');
             }
         }"
    >
        {{-- Onboarding Tour Modal --}}
        <div x-show="tour" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-lg w-full p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-20 h-20 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-icon name="hand-wave" style="duotone" class="w-10 h-10 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Bem-vindo ao Oh Pro!</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8">
                        Estamos felizes em ter você aqui. Vamos fazer um tour rápido para você aproveitar ao máximo sua nova ferramenta de trabalho?
                    </p>
                </div>

                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <div class="w-20 h-20 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-icon name="rocket-launch" style="duotone" class="w-10 h-10 text-purple-600 dark:text-purple-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Workspace & Turmas</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8">
                        No menu lateral, você encontra suas escolas e turmas. Selecione uma turma para gerenciar notas, faltas e diários de forma unificada.
                    </p>
                </div>

                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                     <div class="w-20 h-20 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-icon name="sparkles" style="duotone" class="w-10 h-10 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Inteligência Artificial</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8">
                        Use o botão "Criar com IA" para gerar planos de aula e atividades em segundos, totalmente alinhados à BNCC.
                    </p>
                </div>

                <div class="flex items-center justify-between">
                    <button @click="finish()" class="text-sm text-slate-500 hover:text-slate-800 dark:hover:text-slate-300">Pular Tour</button>
                    <button @click="next()" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-colors">
                        <span x-text="step === 3 ? 'Começar!' : 'Próximo'">Próximo</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Dashboard Content --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Quick Stats --}}
            <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl">
                            <x-icon name="chalkboard-user" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Turmas Ativas</p>
                            <p class="text-2xl font-bold text-slate-900 dark:text-white">12</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl">
                            <x-icon name="book-sparkles" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Planos com IA</p>
                            <p class="text-2xl font-bold text-slate-900 dark:text-white">45</p>
                        </div>
                    </div>
                </div>
                <!-- ... more stats -->
            </div>

            {{-- Next Lesson Widget --}}
            <div class="md:col-span-2 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

                <h3 class="text-indigo-100 font-bold uppercase tracking-wider text-sm mb-2">Sua Próxima Aula</h3>
                <div class="flex items-end justify-between relative z-10">
                    <div>
                        <h2 class="text-4xl font-display font-bold mb-1">9º Ano B</h2>
                        <p class="text-xl text-indigo-100">Matemática · EMEF Centro</p>
                    </div>
                    <div class="text-right">
                         <p class="text-3xl font-bold">14:00</p>
                         <p class="text-indigo-200">Em 45 min</p>
                    </div>
                </div>

                <div class="mt-8 flex gap-3 relative z-10">
                    <button class="px-6 py-3 bg-white text-indigo-600 rounded-xl font-bold shadow-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                        <x-icon name="play" style="solid" class="w-4 h-4" />
                        Iniciar Aula
                    </button>
                    <button class="px-6 py-3 bg-indigo-500/20 border border-white/20 text-white rounded-xl font-bold hover:bg-indigo-500/30 transition-colors">
                        Ver Plano
                    </button>
                </div>
            </div>

            {{-- Notifications/Feed --}}
            <div class="md:col-span-1 bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-slate-900 dark:text-white mb-4">Avisos Recentes</h3>
                <div class="space-y-4">
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 flex gap-3">
                         <div class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></div>
                         <div>
                             <p class="text-sm font-semibold text-slate-900 dark:text-white">Reunião Pedagógica</p>
                             <p class="text-xs text-slate-500 dark:text-slate-400">Amanhã, às 18:00</p>
                         </div>
                    </div>
                     <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 flex gap-3">
                         <div class="mt-1 w-2 h-2 rounded-full bg-amber-500 shrink-0"></div>
                         <div>
                             <p class="text-sm font-semibold text-slate-900 dark:text-white">Prazo de Notas</p>
                             <p class="text-xs text-slate-500 dark:text-slate-400">Fechar diários até dia 30/06</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
