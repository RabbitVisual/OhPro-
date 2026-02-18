<x-layouts.guest title="Planos — Oh Pro!">
    <div class="relative min-h-screen bg-white dark:bg-slate-950 font-sans">
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-500/10 dark:bg-indigo-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[350px] h-[350px] bg-purple-500/10 dark:bg-purple-900/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <x-HomePage::navbar />

        <main class="relative z-10 container mx-auto px-4 py-16 sm:py-24 max-w-6xl">
            <header class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 font-semibold text-sm border border-indigo-100 dark:border-indigo-800 mb-6">
                    <x-icon name="tags" style="duotone" class="fa-sm" />
                    <span>Preços simples</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-slate-900 dark:text-white tracking-tight mb-4">
                    Escolha seu <span class="text-transparent bg-clip-text bg-linear-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">plano</span>
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Todos começam no Gratuito. Assine Pro ou Pro Anual quando precisar de mais turmas e recursos.
                </p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch max-w-5xl mx-auto">
                @foreach($plans as $plan)
                    @php
                        $isFree = $plan->key === 'free';
                        $isProAnnual = $plan->key === 'pro_annual';
                        $highlight = $plan->key === 'pro';
                    @endphp
                    <div class="flex flex-col rounded-2xl border-2 bg-white dark:bg-slate-900 overflow-hidden transition-all
                        {{ $highlight ? 'border-indigo-500 dark:border-indigo-500 shadow-xl shadow-indigo-500/10 scale-[1.02] md:scale-105' : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700' }}">
                        @if($highlight)
                            <div class="bg-indigo-600 text-white text-center py-2 text-sm font-bold">Mais popular</div>
                        @endif
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 mb-2">
                                <x-icon name="{{ $isFree ? 'gift' : ($isProAnnual ? 'calendar-star' : 'bolt') }}" style="duotone" class="text-indigo-500 fa-lg" />
                                <h2 class="text-xl font-display font-bold text-slate-900 dark:text-white">{{ $plan->name }}</h2>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">{{ $plan->description }}</p>
                            <div class="mb-6">
                                @if($isFree)
                                    <span class="text-3xl font-bold text-slate-900 dark:text-white">Grátis</span>
                                    <span class="text-slate-500 dark:text-slate-400 text-sm"> para sempre</span>
                                @else
                                    <span class="text-3xl font-bold text-slate-900 dark:text-white">{{ $plan->formattedPriceMonthly() }}</span>
                                    <span class="text-slate-500 dark:text-slate-400 text-sm">/mês</span>
                                    @if($isProAnnual && $plan->formattedPriceYearly())
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $plan->formattedPriceYearly() }}/ano (2 meses grátis)</p>
                                    @endif
                                @endif
                            </div>
                            <ul class="space-y-3 mb-8 flex-1">
                                @foreach($plan->features ?? [] as $feature)
                                    <li class="flex items-start gap-2 text-sm text-slate-700 dark:text-slate-300">
                                        <x-icon name="check" style="duotone" class="text-emerald-500 fa-sm shrink-0 mt-0.5" />
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-auto">
                                @if($isFree)
                                    <a href="{{ route('register') }}" class="block w-full py-4 px-6 rounded-xl font-bold text-center border-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                        Começar grátis
                                    </a>
                                @else
                                    @auth
                                        <a href="{{ route('billing.index') }}?plan={{ $plan->key }}" class="block w-full py-4 px-6 rounded-xl font-bold text-center bg-indigo-600 text-white hover:bg-indigo-700 transition-colors">
                                            Assinar {{ $plan->name }}
                                        </a>
                                    @else
                                        <a href="{{ route('register', ['plan' => $plan->key]) }}" class="block w-full py-4 px-6 rounded-xl font-bold text-center bg-indigo-600 text-white hover:bg-indigo-700 transition-colors">
                                            Assinar {{ $plan->name }}
                                        </a>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-center text-slate-500 dark:text-slate-400 text-sm mt-12">
                Todos começam no Gratuito. Cancele quando quiser. Sem compromisso.
            </p>

            <div class="mt-20 text-center">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-colors">
                    <x-icon name="rocket-launch" style="duotone" class="fa-sm" />
                    Criar conta grátis
                </a>
            </div>
        </main>

        <x-HomePage::footer />
    </div>
</x-layouts.guest>
