<section id="sobre" class="py-24 bg-white dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-indigo-600 dark:bg-indigo-800 rounded-[3rem] overflow-hidden p-12 md:p-24 text-center">
            <!-- Background effects -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-950/20 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative z-10 max-w-4xl mx-auto space-y-10">
                <div class="flex justify-center">
                    <span class="flex items-center justify-center w-20 h-20 rounded-2xl bg-white/10 text-white/90 border border-white/20">
                        <x-icon :name="config('icon.homepage.cta', 'graduation-cap')" style="duotone" class="text-4xl" />
                    </span>
                </div>
                <h2 class="text-4xl md:text-6xl font-display font-bold text-white leading-tight">
                    Pronto para transformar <br class="hidden md:block"> sua forma de ensinar?
                </h2>
                <p class="text-xl text-indigo-100 leading-relaxed max-w-2xl mx-auto">
                    Junte-se aos professores que já usam o Oh Pro! para ganhar tempo e cumprir as exigências com leveza.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-12 py-6 bg-white text-indigo-600 rounded-2xl font-bold text-xl shadow-2xl hover:bg-slate-50 transition-all hover:-translate-y-1 active:translate-y-0 text-center">
                        Começar Agora Grátis
                    </a>
                    <a href="{{ route('contact') }}" class="w-full sm:w-auto px-12 py-6 bg-transparent text-white border-2 border-white/30 rounded-2xl font-bold text-xl hover:bg-white/10 transition-all text-center">
                        Falar com Consultor
                    </a>
                </div>
                <p class="text-indigo-200 text-sm">Não requer cartão de crédito • Desinstale a qualquer momento</p>
            </div>
        </div>
    </div>
</section>
