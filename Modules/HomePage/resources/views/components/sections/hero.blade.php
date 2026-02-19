<section class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden bg-white dark:bg-slate-950">
    <!-- Background Decor -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-50/50 dark:bg-indigo-900/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-50/50 dark:bg-purple-900/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8 text-center lg:text-left relative z-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 font-semibold text-sm border border-indigo-100 dark:border-indigo-900 shadow-sm backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span>A plataforma #1 para professores</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-display font-bold text-slate-950 dark:text-white leading-[1.1] tracking-tight">
                    Planeje aulas em <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 dark:from-indigo-400 dark:via-purple-400 dark:to-pink-400 animate-gradient-x">segundos, não horas.</span>
                </h1>

                <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    O VertexOh! Pro une Inteligência Artificial e gestão escolar. Crie planos de aula alinhados à BNCC, faça chamadas e lance notas em uma única tela.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-4 py-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="group w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all hover:-translate-y-1 active:translate-y-0 text-center flex items-center justify-center gap-2">
                        Começar Grátis
                        <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </a>
                    <a href="#funcionalidades" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 rounded-2xl font-bold text-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-center flex items-center justify-center gap-2">
                        <x-icon name="play-circle" style="duotone" class="w-5 h-5 text-indigo-500" />
                        Ver como funciona
                    </a>
                </div>

                <div class="flex items-center gap-4 justify-center lg:justify-start text-sm text-slate-500 dark:text-slate-400">
                    <div class="flex items-center gap-1">
                        <x-icon name="check" class="w-4 h-4 text-emerald-500" />
                        <span>Sem cartão de crédito</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-icon name="check" class="w-4 h-4 text-emerald-500" />
                        <span>Plano Gratuito Vitalício</span>
                    </div>
                </div>
            </div>

            <div class="relative group hidden lg:block">
                <!-- Mockup realista do Workspace do professor -->
                <div class="relative z-10 bg-white dark:bg-slate-900 p-5 rounded-3xl shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] border border-slate-200 dark:border-slate-700 transform rotate-1 group-hover:rotate-0 transition-transform duration-500 max-w-lg">
                    {{-- Barra do navegador (demo) --}}
                    <div class="h-3 flex items-center gap-1.5 mb-5">
                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                        <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                        <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                        <div class="flex-1 min-w-0 mx-2">
                            <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded text-[10px] text-slate-400 flex items-center px-2 truncate">ohpro.app/workspace</div>
                        </div>
                    </div>

                    {{-- Widget Sua Próxima Aula --}}
                    <div class="mb-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 p-3">
                        <h3 class="text-sm font-display font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-1.5">
                            <x-icon name="clock-desk" style="duotone" class="text-indigo-500 fa-sm" />
                            <x-icon name="bolt" style="duotone" class="fa-sm text-amber-500" />
                            Sua Próxima Aula
                        </h3>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">9º Ano — Matemática</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Segunda, 24/02/2025 às 14:00 · EMEF Centro</p>
                        <div class="mt-2 flex flex-wrap gap-1.5">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-indigo-600 text-white text-xs font-medium">
                                <x-icon name="play" style="duotone" class="fa-xs" /> Iniciar Aula
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 text-xs">Fazer Chamada</span>
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 text-xs">Ver plano</span>
                        </div>
                    </div>

                    {{-- Minhas escolas --}}
                    <div class="mb-4">
                        <h3 class="text-sm font-display font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-1.5">
                            <x-icon name="school" style="duotone" class="text-indigo-500 fa-sm" />
                            Minhas escolas
                        </h3>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border-2 border-indigo-500 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> EMEF Centro
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border-2 border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 text-xs font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Colégio Alpha
                            </span>
                        </div>
                    </div>

                    <div class="h-1 rounded-full mb-4 bg-indigo-500/80"></div>

                    {{-- Turmas --}}
                    <div class="flex items-center justify-between flex-wrap gap-2 mb-3">
                        <h3 class="text-sm font-display font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                            <x-icon name="chalkboard-user" style="duotone" class="text-indigo-500 fa-sm" />
                            Turmas — EMEF Centro
                        </h3>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-indigo-600 text-white text-xs font-medium">
                            <x-icon name="book-open-reader" style="duotone" class="fa-xs" /> Planos de aula
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors">
                            <p class="font-display font-semibold text-slate-900 dark:text-white text-sm">9º Ano — Matemática</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">9º ano · Matemática</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors">
                            <p class="font-display font-semibold text-slate-900 dark:text-white text-sm">8º Ano — Português</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">8º ano · Língua Portuguesa</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors sm:col-span-2">
                            <p class="font-display font-semibold text-slate-900 dark:text-white text-sm">7º Ano — Ciências</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">7º ano · Ciências</p>
                        </div>
                    </div>
                </div>

                {{-- Badge flutuante: Nota salva --}}
                <div class="absolute -top-6 -right-4 z-20 bg-emerald-500 text-white px-4 py-2 rounded-xl shadow-lg flex items-center gap-2 text-sm font-medium">
                    <x-icon name="check" style="duotone" class="fa-sm" />
                    Nota salva!
                </div>
                {{-- Badge flutuante: o que realmente temos --}}
                <div class="absolute -bottom-4 -left-4 z-20 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                            <x-icon name="pen-to-square" style="duotone" class="text-lg text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Diário de classe</p>
                            <p class="font-bold text-slate-800 dark:text-white text-sm">Assinatura digital</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
