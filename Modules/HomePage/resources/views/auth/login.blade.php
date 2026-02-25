<x-layouts.guest title="Entrar — Oh Pro!">
    <div class="flex min-h-screen bg-white dark:bg-slate-950">
        <!-- Left Side: Branding & Info (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-indigo-600 dark:bg-indigo-900 overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-white/10 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-indigo-950/20 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2"></div>
            </div>

            <div class="relative z-10 w-full flex flex-col justify-between p-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-10 w-10 brightness-0 invert shadow-lg transition-transform group-hover:scale-110" alt="Logo">
                    <span class="text-3xl font-display font-bold text-white tracking-tight">Oh Pro!</span>
                </a>

                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-white font-medium text-sm backdrop-blur-md border border-white/20">
                         <x-icon :name="config('icon.auth.chalkboard', 'chalkboard-user')" style="duotone" />
                         <span>Feito por professores, para professores</span>
                    </div>
                    <h2 class="text-5xl font-display font-bold text-white leading-tight">
                        Transforme sua rotina <br> pedagógica hoje.
                    </h2>
                    <p class="text-xl text-indigo-100 leading-relaxed max-w-lg">
                        Acesse suas aulas, planejamentos e relatórios em um só lugar. A produtividade que você merece está a um clique.
                    </p>
                </div>

                <div class="flex items-center justify-between text-indigo-100/60 text-sm">
                    <p>© 2026 Vertex Solutions LTDA.</p>
                    <div class="flex gap-4">
                        <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Termos</a>
                        <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacidade</a>
                        <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Ajuda</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24 overflow-y-auto">
            <div class="w-full max-w-md space-y-10" x-data="{ loginType: 'email' }">
                <!-- Mobile Header -->
                <div class="lg:hidden flex justify-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-12 w-12" alt="Logo">
                        <span class="text-2xl font-display font-bold text-indigo-600 dark:text-indigo-400">Oh Pro!</span>
                    </a>
                </div>

                <div class="space-y-2">
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white">Bem-vindo de volta!</h1>
                    <p class="text-slate-500 dark:text-slate-400">Acesse sua conta para continuar.</p>
                </div>

                <!-- Tabs -->
                <div class="flex p-1 bg-slate-100 dark:bg-slate-900 rounded-2xl">
                    <button @click="loginType = 'email'"
                            :class="loginType === 'email' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                            class="flex-1 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                        E-mail
                    </button>
                    <button @click="loginType = 'cpf'"
                            :class="loginType === 'cpf' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                            class="flex-1 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                        CPF
                    </button>
                </div>

                @if(app()->environment('local'))
                    <!-- Auto-login for Demo Dev Mode -->
                    <form action="{{ route('login') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="email" value="demo@ohpro.com.br">
                        <input type="hidden" name="password" value="password">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-900/50 rounded-2xl font-bold transition-all border border-emerald-200 dark:border-emerald-800">
                            <x-icon name="bolt" style="duotone" />
                            Login Rápido (Demo Dev)
                        </button>
                    </form>
                    <div class="relative flex pb-6 pt-2 items-center">
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                        <span class="flex-shrink-0 mx-4 text-slate-400 text-sm">Ou acesse com</span>
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2" x-show="loginType === 'email'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Endereço de E-mail</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <x-icon :name="config('icon.auth.envelope', 'envelope')" style="duotone" />
                            </div>
                            <input type="email" id="email" name="email" required
                                   class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none"
                                   placeholder="seu@email.com">
                        </div>
                        @error('email') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- CPF Field -->
                    <div class="space-y-2" x-show="loginType === 'cpf'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <label for="cpf" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Número do CPF</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <x-icon name="id-card" style="duotone" />
                            </div>
                            <input type="text" id="cpf" name="cpf" x-mask="'cpf'"
                                   class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none"
                                   placeholder="000.000.000-00">
                        </div>
                        @error('cpf') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Sua Senha</label>
                            <a href="{{ route('password.request') }}" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700">Esqueceu a senha?</a>
                        </div>
                        <div class="relative group" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <x-icon :name="config('icon.auth.lock', 'lock')" style="duotone" />
                            </div>
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                   class="block w-full pl-11 pr-12 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none"
                                   placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <span x-show="!show">
                                    <x-icon name="eye" style="duotone" />
                                </span>
                                <span x-show="show" style="display: none;">
                                    <x-icon name="eye-slash" style="duotone" />
                                </span>
                            </button>
                        </div>
                        @error('password') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-5 h-5 rounded border-slate-200 dark:border-slate-800 text-indigo-600 focus:ring-indigo-500/20 bg-slate-50 dark:bg-slate-900 transition-all">
                        <label for="remember" class="ml-3 text-sm font-medium text-slate-600 dark:text-slate-400 cursor-pointer">Lembrar de mim</label>
                    </div>

                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-100 dark:shadow-none transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                        Acessar Minha Conta
                        <x-icon name="arrow-right" style="duotone" class="text-sm" />
                    </button>
                </form>

                <div class="pt-8 text-center sm:text-left">
                    <p class="text-slate-600 dark:text-slate-400">
                        Ainda não tem uma conta?
                        <a href="{{ route('register') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 underline underline-offset-4 decoration-2">Registre-se agora grátis</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
