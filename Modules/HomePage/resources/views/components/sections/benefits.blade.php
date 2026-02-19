<section id="funcionalidades" class="py-32 bg-slate-50/50 dark:bg-slate-950/50 relative overflow-hidden">
    {{-- Decorative Blobs --}}
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-purple-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
            <h2 class="text-indigo-600 dark:text-indigo-400 font-bold tracking-widest uppercase text-sm">Funcionalidades</h2>
            <p class="text-4xl md:text-5xl font-display font-bold text-slate-950 dark:text-white leading-tight">
                Tudo o que você precisa <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">em um só lugar.</span>
            </p>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                Desenvolvemos ferramentas específicas para o fluxo de trabalho real dos professores brasileiros.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $featureIcons = config('icon.homepage.features', ['folder-open', 'book', 'chalkboard-user', 'calendar-days', 'cart-shopping', 'users']);
                $colorClasses = [
                    'indigo' => 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 ring-indigo-100 dark:ring-indigo-900',
                    'purple' => 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 ring-purple-100 dark:ring-purple-900',
                    'emerald' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 ring-emerald-100 dark:ring-emerald-900',
                    'blue' => 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 ring-blue-100 dark:ring-blue-900',
                    'amber' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 ring-amber-100 dark:ring-amber-900',
                    'rose' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 ring-rose-100 dark:ring-rose-900',
                ];
                $features = [
                    ['title' => 'Workspace Escolar', 'desc' => 'Organize suas escolas e turmas em um só lugar. Troque de escola com um clique e acesse tudo rapidamente.', 'color' => 'indigo'],
                    ['title' => 'IA Geradora de Planos', 'desc' => 'Crie planos de aula completos e alinhados à BNCC em segundos. Personalize objetivos e metodologia.', 'color' => 'purple'],
                    ['title' => 'Notas Automáticas', 'desc' => 'Planilha de notas inteligente com cálculo automático de média e salvamento automático.', 'color' => 'emerald'],
                    ['title' => 'Chamada Rápida', 'desc' => 'Chamada em cards grandes e intuitivos. Um toque para presente, dois para ausente.', 'color' => 'blue'],
                    ['title' => 'Diário e Assinatura', 'desc' => 'Gere PDFs dos seus diários prontos para imprimir ou assinar digitalmente.', 'color' => 'amber'],
                    ['title' => 'Painel Próxima Aula', 'desc' => 'Saiba exatamente onde é sua próxima aula e o que você planejou para ela.', 'color' => 'rose'],
                ];
            @endphp

            @foreach($features as $index => $feature)
                <div class="group p-8 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-100/50 dark:hover:shadow-none hover:border-indigo-200 dark:hover:border-indigo-900 relative overflow-hidden">
                     <div class="absolute top-0 right-0 p-6 opacity-0 group-hover:opacity-10 transition-opacity">
                         <x-icon :name="$featureIcons[$index] ?? 'circle'" style="duotone" class="w-24 h-24 {{ $feature['color'] === 'indigo' ? 'text-indigo-600' : 'text-gray-400' }}" />
                     </div>
                    <div class="w-14 h-14 rounded-2xl mb-6 flex items-center justify-center {{ $colorClasses[$feature['color']] ?? $colorClasses['indigo'] }} ring-4 ring-opacity-50 group-hover:scale-110 transition-transform duration-300">
                        <x-icon :name="$featureIcons[$index] ?? 'circle'" style="duotone" size="xl" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-950 dark:text-white mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm">
                        {{ $feature['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="beneficios" class="py-32 bg-white dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative">
                <div class="aspect-square bg-indigo-600 rounded-3xl overflow-hidden shadow-2xl relative">
                    <img src="{{ asset('storage/Default/prounsplash.avif') }}" alt="Educador" class="w-full h-full object-cover opacity-80 mix-blend-overlay">
                    <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/80 to-transparent"></div>
                    <div class="absolute bottom-10 left-10 text-white space-y-2">
                        <p class="text-4xl font-display font-bold">Produtividade</p>
                        <p class="text-indigo-200">Ganhe tempo na preparação de aulas.</p>
                    </div>
                </div>
                <!-- Float card -->
                <div class="absolute -top-10 -right-10 bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-800" data-aos="fade-left">
                    <div class="flex items-center gap-4 mb-4">
                        <x-icon :name="config('icon.homepage.check', 'check-circle')" style="duotone" class="text-emerald-500" size="2xl" />
                        <p class="font-bold text-slate-800 dark:text-white">Qualidade Garantida</p>
                    </div>
                    <p class="text-sm text-slate-500">Materiais revisados e alinhados <br>com as normas pedagógicas.</p>
                </div>
            </div>

            <div class="space-y-10">
                <div class="space-y-4">
                    <h2 class="text-indigo-600 dark:text-indigo-400 font-bold tracking-widest uppercase text-sm">Benefícios</h2>
                    <p class="text-4xl md:text-5xl font-display font-bold text-slate-950 dark:text-white leading-tight">
                        Por que escolher o Oh Pro!?
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                            <x-icon name="check" style="duotone" class="text-indigo-600 dark:text-indigo-400" size="xs" />
                        </div>
                        <div>
                            <p class="font-bold text-slate-950 dark:text-white mb-1">Simplicidade e Usabilidade</p>
                            <p class="text-slate-600 dark:text-slate-400">Desenvolvido para ser usado por qualquer pessoa, sem necessidade de conhecimentos técnicos.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                            <x-icon name="check" style="duotone" class="text-indigo-600 dark:text-indigo-400" size="xs" />
                        </div>
                        <div>
                            <p class="font-bold text-slate-950 dark:text-white mb-1">Aulas mais Atrativas</p>
                            <p class="text-slate-600 dark:text-slate-400">Mantenha seus alunos engajados com conteúdos mais visuais e dinâmicos.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                            <x-icon name="check" style="duotone" class="text-indigo-600 dark:text-indigo-400" size="xs" />
                        </div>
                        <div>
                            <p class="font-bold text-slate-950 dark:text-white mb-1">Segurança de Dados</p>
                            <p class="text-slate-600 dark:text-slate-400">Seus conteúdos e informações de alunos protegidos com tecnologia de ponta.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-bold group">
                        Saiba mais sobre a nossa filosofia
                        <x-icon :name="config('icon.homepage.arrow_right', 'arrow-right')" style="duotone" class="group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
