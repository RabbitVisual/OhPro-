<x-layouts.guest title="Recuperar Senha — Oh Pro!">
    <div class="flex min-h-screen bg-white dark:bg-slate-950">
        <!-- Left Side (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">
             <!-- Background Decoration -->
             <div class="absolute inset-0 z-0 opacity-50">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-500/10 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[100px]"></div>
            </div>

            <div class="relative z-10 w-full flex flex-col justify-between p-16 text-white">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-10 w-10 brightness-0 invert shadow-lg transition-transform group-hover:scale-110" alt="Logo">
                    <span class="text-3xl font-display font-bold tracking-tight">Oh Pro!</span>
                </a>

                <div class="space-y-8">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center border border-white/20">
                         <x-icon :name="config('icon.auth.key', 'key')" style="duotone" size="2xl" class="text-indigo-400" />
                    </div>
                    <h2 class="text-5xl font-display font-bold leading-tight">
                        Esqueceu sua senha? <br> Não se preocupe.
                    </h2>
                    <p class="text-xl text-slate-400 leading-relaxed max-w-lg">
                        Enviaremos um link de recuperação para o seu e-mail para que você possa redefinir sua senha com segurança.
                    </p>
                </div>

                <div class="flex items-center justify-between text-slate-500 text-sm mt-auto">
                    <p>© 2026 Vertex Solutions LTDA.</p>
                    <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Precisa de ajuda?</a>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24">
            <div class="w-full max-w-md space-y-10">
                 <!-- Mobile Header -->
                <div class="lg:hidden flex justify-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-12 w-12" alt="Logo">
                        <span class="text-2xl font-display font-bold text-indigo-600 dark:text-indigo-400">Oh Pro!</span>
                    </a>
                </div>

                <div class="space-y-4">
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white">Recuperação de Senha</h1>
                    <p class="text-slate-600 dark:text-slate-400">Insira seu e-mail cadastrado e enviaremos o link de redefinição.</p>
                </div>

                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Endereço de E-mail</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <x-icon :name="config('icon.auth.envelope', 'envelope')" style="duotone" />
                            </div>
                            <input type="email" id="email" name="email" required
                                   class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none"
                                   placeholder="seu@email.com">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-100 dark:shadow-none transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                        Enviar Link de Recuperação
                        <x-icon name="paper-plane" style="duotone" class="text-sm" />
                    </button>

                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 font-bold transition-all">
                        <x-icon name="arrow-left" style="duotone" class="text-sm" />
                        Voltar para o Login
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-layouts.guest>
