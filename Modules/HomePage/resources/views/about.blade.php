<x-layouts.guest title="Sobre Nós — Oh Pro!">
    <div class="relative min-h-screen bg-slate-50 dark:bg-slate-950 overflow-hidden">
        <!-- Navbar -->
        <x-HomePage::navbar />

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-500/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>
            </div>

            <div class="container mx-auto px-4 relative z-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-semibold text-sm border border-indigo-200 dark:border-indigo-800 mb-8 animate-fade-in-up">
                    <x-icon name="rocket-launch" style="duotone" />
                    <span>Nossa Missão Educacional</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-display font-bold text-slate-900 dark:text-white leading-tight mb-8 max-w-4xl mx-auto">
                    Transformando a Educação com <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Tecnologia e Empatia</span>.
                </h1>
                <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto">
                    O Oh Pro! nasceu para apoiar professores no ensino moderno: workspace com escolas e turmas, planos de aula, notas, chamada e diário de classe com assinatura digital.
                </p>
            </div>
        </section>

        <!-- Content Sections -->
        <section class="py-20 bg-white dark:bg-slate-900 relative z-10">
            <div class="container mx-auto px-4">

                <!-- The Problem -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-32">
                    <div class="relative">
                        <div class="aspect-square bg-indigo-100 dark:bg-slate-800 rounded-[3rem] overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 to-purple-600/20 mix-blend-overlay"></div>
                            <!-- Abstract shapes representing chaos/organization -->
                            <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-rose-400 rounded-full blur-xl opacity-60 animate-pulse"></div>
                            <div class="absolute bottom-1/3 right-1/4 w-40 h-40 bg-indigo-400 rounded-full blur-xl opacity-60 animate-pulse delay-700"></div>

                            <div class="absolute inset-0 flex items-center justify-center p-8">
                                <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-8 rounded-3xl border border-white/20 shadow-2xl space-y-4 max-w-sm">
                                    <div class="flex items-center gap-4 text-slate-400">
                                        <x-icon name="clock" style="duotone" class="text-rose-500" />
                                        <span class="line-through">Falta de tempo</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-slate-400">
                                        <x-icon name="files" style="duotone" class="text-rose-500" />
                                        <span class="line-through">Desorganização</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-slate-800 dark:text-white font-bold text-lg">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white">
                                            <x-icon name="check" style="duotone" size="sm" />
                                        </div>
                                        <span>Produtividade</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-8">
                        <h2 class="text-4xl font-display font-bold text-slate-900 dark:text-white">
                            O desafio do professor moderno
                        </h2>
                        <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            Sabemos que professores enfrentam excesso de tarefas, pouco tempo para planejar aulas de qualidade e dificuldades para manter os alunos engajados em um mundo saturado de informação digital.
                        </p>
                        <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            O sistema atual muitas vezes sobrecarrega o educador com ferramentas desconectadas e burocracia, tirando o foco do que realmente importa: <strong>ensinar</strong>.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                                <x-icon name="xmark" style="duotone" class="text-rose-500" />
                                <span class="font-medium text-slate-700 dark:text-slate-300">Aulas pouco atrativas</span>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                                <x-icon name="xmark" style="duotone" class="text-rose-500" />
                                <span class="font-medium text-slate-700 dark:text-slate-300">Planejamento complexo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Solution -->
                <div class="bg-slate-50 dark:bg-slate-950 rounded-[3rem] p-8 md:p-16 mb-32 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-500/5 rounded-full blur-[100px]"></div>

                    <div class="max-w-4xl mx-auto text-center space-y-12 relative z-10">
                        <h2 class="text-4xl font-display font-bold text-slate-900 dark:text-white">
                            Oh Pro!: sua solução prática
                        </h2>
                        <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
                            Não somos apenas mais uma ferramenta. Somos uma plataforma completa de apoio pedagógico, criada para devolver ao professor sua autonomia e tempo.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                            <div class="p-8 bg-white dark:bg-slate-900 rounded-3xl shadow-lg border border-slate-100 dark:border-slate-800">
                                <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-6">
                                    <x-icon name="layer-group" style="duotone" size="xl" />
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Organização Visual</h3>
                                <p class="text-slate-600 dark:text-slate-400">Estruture conteúdos de forma clara, tornando conceitos complexos em explicações simples e visuais.</p>
                            </div>
                            <div class="p-8 bg-white dark:bg-slate-900 rounded-3xl shadow-lg border border-slate-100 dark:border-slate-800">
                                <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-6">
                                    <x-icon name="wand-magic-sparkles" style="duotone" size="xl" />
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Didática Aprimorada</h3>
                                <p class="text-slate-600 dark:text-slate-400">Recursos prontos que engajam alunos acostumados com o digital, sem perder a essência pedagógica.</p>
                            </div>
                            <div class="p-8 bg-white dark:bg-slate-900 rounded-3xl shadow-lg border border-slate-100 dark:border-slate-800">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-6">
                                    <x-icon name="stopwatch" style="duotone" size="xl" />
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Economia de Tempo</h3>
                                <p class="text-slate-600 dark:text-slate-400">Reduza drasticamente o tempo de preparação de aulas com nossas ferramentas inteligentes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Philosophy -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8 order-2 lg:order-1">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 font-semibold text-sm border border-amber-200 dark:border-amber-800">
                            <x-icon name="heart" style="duotone" />
                            <span>Nossa Filosofia</span>
                        </div>
                        <h2 class="text-4xl font-display font-bold text-slate-900 dark:text-white">
                            Tecnologia com Propósito Humano
                        </h2>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-1">
                                    <span class="font-bold">1</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">O Professor no Centro</h4>
                                    <p class="text-slate-600 dark:text-slate-400">Acreditamos que a tecnologia deve servir à educação, jamais substituir a figura insubstituível do mentor.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-1">
                                    <span class="font-bold">2</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">Simplicidade Radical</h4>
                                    <p class="text-slate-600 dark:text-slate-400">Ferramentas educacionais não podem ser complexas. Nosso design é "clique e use", para qualquer nível de habilidade técnica.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-1">
                                    <span class="font-bold">3</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">Empatia Pedagógica</h4>
                                    <p class="text-slate-600 dark:text-slate-400">Ensinar bem é unir didática, organização e empatia. Nossa plataforma reflete esses valores em cada detalhe.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative order-1 lg:order-2">
                        <div class="aspect-[4/3] bg-indigo-900 rounded-[3rem] overflow-hidden relative shadow-2xl skew-y-3 lg:skew-y-0 lg:-skew-x-3 transform transition-transform hover:skew-x-0 duration-700">
                             <div class="absolute inset-0 bg-gradient-to-tr from-indigo-900 to-purple-800 opacity-90"></div>
                             <!-- Decorative UI abstract -->
                             <div class="absolute inset-0 flex items-center justify-center">
                                <x-icon name="user-graduate" size="4xl" class="text-white/20 scale-[5]" />
                             </div>
                             <div class="absolute bottom-10 left-10 right-10 p-8 bg-white/10 backdrop-blur-md rounded-3xl border border-white/20">
                                <p class="text-white font-display text-2xl font-bold">"Educar é impregnar de sentido o que fazemos a cada instante."</p>
                                <p class="text-indigo-200 mt-4 font-medium">— Paulo Freire (Inspiração)</p>
                             </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- CTA -->
        <x-HomePage::sections.cta />

        <x-HomePage::footer />
    </div>
</x-layouts.guest>
