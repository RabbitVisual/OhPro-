<x-teacher::layouts.master title="Dashboard — Oh Pro!">
    <div class="w-full space-y-8 pb-12"
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
        {{-- Page header --}}
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight">
                    Olá, {{ auth()->user()->first_name }}! 👋
                </h1>
                <p class="mt-1 text-slate-500 dark:text-slate-400">
                    Aqui está o que está acontecendo nas suas turmas hoje.
                </p>
                <a href="{{ route('billing.index') }}" class="mt-2 inline-flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <x-icon name="credit-card" style="duotone" class="w-4 h-4" />
                    Plano atual: {{ auth()->user()->plan()->name }}
                    <span class="text-xs">— Gerir assinatura</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <button @click="tour = true" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Ver Tour">
                    <x-icon name="circle-question" size="xl" />
                </button>
                <a href="{{ route('teacher.stats') }}" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                    <x-icon name="chart-line" class="text-indigo-500" />
                    Ver Relatórios
                </a>
            </div>
        </header>

        {{-- Onboarding Tour Modal (Keep original logic) --}}
        <div x-show="tour" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-md" style="display: none;" x-transition>
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-lg w-full p-8 text-center relative overflow-hidden border border-white/10">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-24 h-24 bg-indigo-100 dark:bg-indigo-900/30 rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3">
                        <x-icon name="hand-wave" class="text-4xl text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Bem-vindo ao Oh Pro!</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                        Sua produtividade como professor está prestes a decolar. Vamos conhecer as principais ferramentas?
                    </p>
                </div>

                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <div class="w-24 h-24 bg-purple-100 dark:bg-purple-900/30 rounded-3xl flex items-center justify-center mx-auto mb-6 -rotate-3">
                        <x-icon name="rocket-launch" class="text-4xl text-purple-600 dark:text-purple-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Workspace & Turmas</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                        Centralize tudo! Gerencie notas, faltas e diários de todas as suas escolas em um único lugar, sem trocar de sistema.
                    </p>
                </div>

                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                     <div class="w-24 h-24 bg-emerald-100 dark:bg-emerald-900/30 rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-6">
                        <x-icon name="sparkles" class="text-4xl text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Inteligência Artificial</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                        Crie planos de aula e atividades alinhadas à BNCC em segundos. Clique no ícone de faísca para começar a mágica.
                    </p>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <button @click="finish()" class="text-sm font-medium text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">Pular Tour</button>
                    <button @click="next()" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-500/20 transition-all transform hover:scale-105 active:scale-95">
                        <span x-text="step === 3 ? 'Vamos lá!' : 'Próximo ítem'">Próximo</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- KPI Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Active Classes --}}
            <div class="group bg-white dark:bg-slate-900 p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:shadow-indigo-500/5 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <x-icon name="chalkboard-user" size="2xl" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Turmas Ativas</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white leading-none mt-1">{{ $activeClassesCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- AI Plans --}}
            <div class="group bg-white dark:bg-slate-900 p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:shadow-purple-500/5 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <x-icon name="wand-magic-sparkles" size="2xl" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Planos com IA</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white leading-none mt-1">{{ $aiGenerationsCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- Wallet Balance --}}
            <div class="group bg-white dark:bg-slate-900 p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:shadow-emerald-500/5 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <x-icon name="wallet" size="2xl" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Saldo Disponível</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white leading-none mt-1">R$ {{ number_format($wallet->balance ?? 0, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Pending Diaries --}}
            <div class="group bg-white dark:bg-slate-900 p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:shadow-rose-500/5 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-4 {{ ($pendingDiariesCount ?? 0) > 0 ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-600' : 'bg-slate-50 dark:bg-slate-800/50 text-slate-400' }} rounded-2xl group-hover:scale-110 transition-transform">
                        <x-icon name="calendar-exclamation" size="2xl" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Diários Pendentes</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white leading-none mt-1">{{ $pendingDiariesCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Next Lesson Widget (Left side, larger) --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 rounded-[2.5rem] p-8 md:p-10 text-white relative overflow-hidden shadow-2xl shadow-indigo-500/20">
                    <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-40 h-40 bg-purple-500/20 rounded-full blur-[60px] translate-y-1/2 -translate-x-1/2"></div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-widest text-white border border-white/10">Próxima Aula</span>
                            @if(isset($nextClass) && $nextClass)
                                <span class="animate-pulse w-2 h-2 bg-emerald-400 rounded-full"></span>
                            @endif
                        </div>

                        @if(isset($nextClass) && $nextClass)
                            @php
                                $nextSchedule = $nextClass->schedules->first();
                                $startTime = \Carbon\Carbon::parse($nextSchedule->start_time);
                                $diffInMinutes = now()->diffInMinutes($startTime, false);
                            @endphp
                            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                                <div>
                                    <h2 class="text-4xl md:text-5xl font-display font-bold mb-3 tracking-tight">{{ $nextClass->name }}</h2>
                                    <div class="flex flex-wrap items-center gap-3 text-indigo-100/90 text-lg">
                                        <span class="flex items-center gap-2">
                                            <x-icon name="book-open" class="text-indigo-300" />
                                            {{ $nextClass->course->name ?? 'Múltiplas Disciplinas' }}
                                        </span>
                                        <span class="hidden md:inline text-indigo-100/30">|</span>
                                        <span class="flex items-center gap-2">
                                            <x-icon name="school" class="text-indigo-300" />
                                            {{ $nextClass->school->short_name ?? $nextClass->school->name }}
                                        </span>
                                    </div>
                                </div>
                                <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/10 text-center min-w-[140px]">
                                    <p class="text-4xl font-black mb-0">{{ $startTime->format('H:i') }}</p>
                                    <p class="text-sm font-bold opacity-70 uppercase tracking-tighter">
                                        @if($diffInMinutes > 0 && $diffInMinutes < 60)
                                            Em {{ $diffInMinutes }} min
                                        @elseif($diffInMinutes > 0)
                                            Hoje
                                        @else
                                            Agora
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mt-10 flex flex-wrap gap-4">
                                <a href="{{ route('diary.class.show', $nextClass->id) }}" class="px-8 py-4 bg-white text-indigo-700 rounded-2xl font-bold shadow-xl hover:bg-slate-50 hover:scale-105 transition-all flex items-center gap-3">
                                    <x-icon name="circle-play" size="xl" />
                                    Iniciar Diário de Classe
                                </a>
                                <a href="{{ route('planning.index', ['class_id' => $nextClass->id]) }}" class="px-8 py-4 bg-indigo-500/20 backdrop-blur-md border border-white/20 text-white rounded-2xl font-bold hover:bg-indigo-500/30 transition-all">
                                    Ver Meus Planos
                                </a>
                            </div>
@else
                            <div class="flex flex-col items-center justify-center h-48 text-center">
                                <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center mb-4 border border-white/10">
                                    <x-icon name="mug-hot" size="3xl" class="text-indigo-200" />
                                </div>
                                <h3 class="text-2xl font-bold">Tudo tranquilo por agora!</h3>
                                <p class="text-indigo-100/70 mt-1">Sua agenda para hoje está limpa ou as aulas já acabaram.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Actions Section --}}
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <x-icon name="bolt-lightning" class="text-amber-500" />
                            Ações Rápidas
                        </h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <a href="{{ route('planning.create') }}" class="group p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-indigo-500 dark:hover:border-indigo-500 hover:shadow-xl hover:shadow-indigo-500/5 transition-all text-center">
                            <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                                <x-icon name="file-sparkles" size="2xl" />
                            </div>
                            <span class="block text-sm font-bold text-slate-700 dark:text-slate-300">Novo Plano IA</span>
                        </a>

                        <a href="{{ route('teacher.wallet') }}" class="group p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-500/5 transition-all text-center">
                            <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                                <x-icon name="hand-holding-dollar" size="2xl" />
                            </div>
                            <span class="block text-sm font-bold text-slate-700 dark:text-slate-300">Sacar Saldo</span>
                        </a>

                        <a href="{{ route('library.index') }}" class="group p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-purple-500 dark:hover:border-purple-500 hover:shadow-xl hover:shadow-purple-500/5 transition-all text-center">
                            <div class="w-14 h-14 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                                <x-icon name="books" size="2xl" />
                            </div>
                            <span class="block text-sm font-bold text-slate-700 dark:text-slate-300">Minha Biblioteca</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="group p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-slate-400 dark:hover:border-slate-400 hover:shadow-xl transition-all text-center">
                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                                <x-icon name="user-gear" size="2xl" />
                            </div>
                            <span class="block text-sm font-bold text-slate-700 dark:text-slate-300">Ajustes Conta</span>
                        </a>
                    </div>
                </section>
            </div>

            {{-- Right Sidebar --}}
            <div class="space-y-8">
                {{-- Wallet Widget --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 dark:text-white">Minha Carteira</h3>
                        <x-icon name="shield-check" class="text-emerald-500 opacity-50" />
                    </div>

                    <div class="py-4">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Saldo Total</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-slate-400 text-lg font-bold">R$</span>
                            <span class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ number_format($wallet->balance ?? 0, 2, ',', '.') }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">
                             Disponível para saque: <span class="text-emerald-600 dark:text-emerald-400 font-bold">R$ {{ number_format($wallet->withdrawable_balance ?? 0, 2, ',', '.') }}</span>
                        </p>
                    </div>

                    <a href="{{ route('teacher.wallet') }}" class="mt-4 w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold transition-all shadow-lg shadow-emerald-500/20 text-center block">
                        Ver Detalhes e Sacar
                    </a>
                </div>

                {{-- Notifications/Avisos --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="bell-on" class="text-indigo-500" />
                            Avisos Recentes
                        </h3>
                        <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 font-bold uppercase tracking-tighter">Limpar</a>
                    </div>

                    <div class="space-y-4">
                        @forelse(($recentNotifications ?? []) as $notification)
                            <div class="group p-4 rounded-[1.5rem] bg-slate-50 dark:bg-slate-800/40 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all">
                                <div class="flex gap-4">
                                    <div class="mt-1 w-2 h-2 rounded-full shrink-0 {{ is_null($notification->read_at) ? 'bg-indigo-500 shadow-lg shadow-indigo-500/50' : 'bg-slate-300 dark:bg-slate-600' }}"></div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white leading-tight decoration-indigo-500 group-hover:underline">
                                            {{ $notification->data['title'] ?? 'Novo Aviso' }}
                                        </p>
                                        @if(isset($notification->data['message']))
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                                {{ $notification->data['message'] }}
                                            </p>
                                        @endif
                                        <div class="flex items-center gap-2 mt-3 text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                            <x-icon name="clock-rotate-left" size="xs" />
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-slate-200 dark:border-slate-700">
                                    <x-icon name="bell-slash" size="2xl" class="text-slate-300 dark:text-slate-600" />
                                </div>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-widest">Nenhum aviso</p>
                            </div>
                        @endforelse
                    </div>

                    <a href="{{ route('notifications.index') }}" class="mt-6 block text-center py-3 border border-slate-100 dark:border-slate-800 rounded-2xl text-xs font-bold text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                        Ver histórico completo
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-teacher::layouts.master>
