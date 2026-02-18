<x-layouts.guest title="Minha assinatura — Oh Pro!">
    <div class="relative min-h-screen bg-white dark:bg-slate-950 font-sans">
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-500/10 dark:bg-indigo-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[350px] h-[350px] bg-purple-500/10 dark:bg-purple-900/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <x-HomePage::navbar />

        <main class="relative z-10 container mx-auto px-4 py-16 sm:py-24 max-w-4xl">
            <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">Minha assinatura</h1>
            <p class="text-slate-600 dark:text-slate-400 mb-8">Gerencie seu plano e faça upgrade quando precisar.</p>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="mb-6 p-4 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                    {{ session('info') }}
                </div>
            @endif

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 mb-8">
                <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-2">Plano atual</h2>
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $currentPlan->name }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $currentPlan->description }}</p>
                @if($subscription?->current_period_end)
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        Próxima renovação: {{ $subscription->current_period_end->translatedFormat('d/m/Y') }}
                    </p>
                @endif
                @if($subscription?->isActive() && $currentPlan->isPro())
                    <div class="mt-6 flex flex-wrap gap-3">
                        <form action="{{ route('billing.index') }}" method="get" class="inline">
                            <button type="button" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800">
                                Ver planos
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            @if($currentPlan->key === 'free')
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8">
                    <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-4">Fazer upgrade</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">Escolha Pro ou Pro Anual para turmas ilimitadas e mais recursos.</p>
                    <div class="space-y-4">
                        @foreach($plans->whereNotIn('key', ['free']) as $plan)
                            <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $plan->name }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $plan->formattedPriceMonthly() }}/mês
                                        @if($plan->price_yearly)
                                            ou {{ $plan->formattedPriceYearly() }}/ano
                                        @endif
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('billing.checkout') }}" method="post" class="inline">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="interval" value="month">
                                        <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">Assinar mensal</button>
                                    </form>
                                    @if($plan->price_yearly)
                                        <form action="{{ route('billing.checkout') }}" method="post" class="inline">
                                            @csrf
                                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                            <input type="hidden" name="interval" value="year">
                                            <button type="submit" class="px-4 py-2 rounded-xl border border-indigo-500 text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900/20">Assinar anual</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-4">Pagamento seguro via Stripe ou Mercado Pago. Cancele quando quiser.</p>
                </div>
            @else
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                    <p class="text-slate-600 dark:text-slate-400">Você já está no plano {{ $currentPlan->name }}. Para alterar ou cancelar, entre em contato com o suporte.</p>
                    <a href="{{ route('contact') }}" class="inline-block mt-4 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-200 dark:hover:bg-slate-700">Falar com suporte</a>
                </div>
            @endif
        </main>

        <x-HomePage::footer />
    </div>
</x-layouts.guest>
