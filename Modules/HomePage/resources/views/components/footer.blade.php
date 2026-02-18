<footer class="bg-slate-50 dark:bg-slate-950 pt-24 pb-12 border-t border-slate-200 dark:border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                    <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-8 w-8" alt="Logo">
                    <span class="text-xl font-display font-bold text-slate-900 dark:text-white">Oh Pro!</span>
                </a>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
                    Caderno digital do professor: workspace, planos de aula, notas, chamada e diário com assinatura.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors shadow-sm">
                        <x-icon name="facebook-f" style="brands" />
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors shadow-sm">
                        <x-icon name="instagram" style="brands" />
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors shadow-sm">
                        <x-icon name="linkedin-in" style="brands" />
                    </a>
                </div>
            </div>

            <!-- Links 1 -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-6">Plataforma</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}#funcionalidades" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Funcionalidades</a></li>
                    <li><a href="{{ route('home') }}#beneficios" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Benefícios</a></li>
                    <li><a href="{{ route('about') }}" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Sobre Nós</a></li>
                    <li><a href="#" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Marketplace</a></li>
                    <li><a href="{{ route('plans') }}" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Planos</a></li>
                </ul>
            </div>

            <!-- Links 2 -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-6">Recursos</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('faq') }}" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Documentação & FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Suporte</a></li>
                    <li><a href="{{ route('terms') }}" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Termos de Uso</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">Privacidade</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-6">Suporte</h4>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Dúvida ou sugestão? Entre em contato com nossa equipe.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 font-semibold hover:border-indigo-500 transition-all shadow-sm">
                    <x-icon name="envelope" style="duotone" class="text-indigo-600 dark:text-indigo-400" />
                    Fale Conosco
                </a>
            </div>
        </div>

        <!-- Bottom -->
        <div class="pt-8 border-t border-slate-200 dark:border-slate-900 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500 dark:text-slate-500">
            <p>© 2026 Vertex Solutions LTDA. Desenvolvido com <x-icon name="heart" style="duotone" class="text-red-500" /> por Reinan Rodrigues.</p>
            <div class="flex items-center gap-2">
                <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-5 w-5 grayscale opacity-50" alt="Minor Logo">
                <span class="font-display font-medium uppercase tracking-tighter">Oh Pro!</span>
            </div>
        </div>
    </div>
</footer>
