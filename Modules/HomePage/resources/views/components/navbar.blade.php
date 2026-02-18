<nav x-data="{ isOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
     :class="{ 'bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm': scrolled, 'bg-transparent': !scrolled }"
     class="fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-10 w-10 transform group-hover:scale-110 transition-transform duration-300" alt="Logo Oh Pro!">
                    <span class="text-2xl font-display font-bold tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Oh Pro!</span>
                    </span>
                    <span class="hidden sm:inline text-xs font-medium text-slate-500 dark:text-slate-400 ml-0.5">para professores</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}#funcionalidades" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Funcionalidades</a>
                <a href="{{ route('home') }}#beneficios" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Benefícios</a>
                <a href="{{ route('plans') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Planos</a>
                <a href="{{ route('about') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Sobre</a>
                <a href="{{ route('faq') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">FAQ</a>
                <a href="{{ route('contact') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Contato</a>

                <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-500">
                    <span class="hidden dark:block text-yellow-400">
                        <x-icon name="sun" style="solid" />
                    </span>
                    <span class="block dark:hidden text-slate-600">
                        <x-icon name="moon" style="solid" />
                    </span>
                </button>

                <div class="flex items-center gap-4 border-l border-slate-200 dark:border-slate-800 pl-8">
                    @guest
                        <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Entrar</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full font-semibold shadow-lg shadow-indigo-200 dark:shadow-none transition-all hover:-translate-y-0.5 active:translate-y-0">
                            Começar Agora
                        </a>
                    @else
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('panel.admin') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline transition-all">Painel Admin</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline transition-all">Meu Painel</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" class="text-slate-500 hover:text-red-500 transition-colors">
                                <x-icon name="right-from-bracket" style="solid" />
                            </button>
                        </form>
                    @endguest
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center gap-4">
                <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-500">
                    <span class="hidden dark:block text-yellow-400">
                        <x-icon name="sun" style="solid" />
                    </span>
                    <span class="block dark:hidden text-slate-600">
                        <x-icon name="moon" style="solid" />
                    </span>
                </button>
                <button @click="isOpen = !isOpen" class="text-slate-600 dark:text-slate-300 p-2">
                    <x-icon name="bars" size="lg" x-show="!isOpen" />
                    <x-icon name="xmark" size="lg" x-show="isOpen" />
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}#funcionalidades" class="block px-3 py-3 text-base font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">Funcionalidades</a>
            <a href="{{ route('home') }}#beneficios" class="block px-3 py-3 text-base font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">Benefícios</a>
            <a href="{{ route('plans') }}" class="block px-3 py-3 text-base font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">Planos</a>
            <a href="{{ route('about') }}" class="block px-3 py-3 text-base font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">Sobre</a>
            <a href="{{ route('faq') }}" class="block px-3 py-3 text-base font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">FAQ</a>
            <a href="{{ route('contact') }}" class="block px-3 py-3 text-base font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contato</a>
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-3">
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-3 text-center font-medium text-slate-600 dark:text-slate-300">Entrar</a>
                    <a href="{{ route('register') }}" class="block px-3 py-3 text-center font-bold bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-100 dark:shadow-none">Criar Conta Grátis</a>
                @else
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('panel.admin') }}" class="block px-3 py-3 text-center font-bold text-indigo-600 dark:text-indigo-400">Painel Administrativo</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block px-3 py-3 text-center font-bold text-indigo-600 dark:text-indigo-400">Meu Painel</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-3 py-3 text-center font-medium text-slate-500 hover:text-red-500">Sair da Conta</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
