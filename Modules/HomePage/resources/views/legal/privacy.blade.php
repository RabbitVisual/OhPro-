<x-layouts.guest title="Política de Privacidade — Oh Pro!">
    <div class="relative min-h-screen bg-slate-50 dark:bg-slate-950 overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-indigo-600/10 blur-[120px] rounded-full pointer-events-none"></div>

        <!-- Navbar -->
        <x-HomePage::navbar />

        <main class="relative z-10 container mx-auto px-4 py-24 sm:py-32">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-semibold text-sm border border-indigo-200 dark:border-indigo-800">
                    <x-icon name="shield-check" style="duotone" />
                    <span>Seus dados estão seguros conosco</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-slate-900 dark:text-white">
                    Política de Privacidade
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400">
                    Transparência sobre como coletamos, usamos e protegemos suas informações.
                </p>
            </div>

            <!-- Content Card -->
            <div class="max-w-4xl mx-auto bg-white dark:bg-slate-900 rounded-3xl p-8 sm:p-12 shadow-xl border border-slate-100 dark:border-slate-800 space-y-12">

                <!-- Section 1 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <x-icon name="database" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">1. Coleta de Dados</h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed pl-16">
                        Coletamos informações que você nos fornece diretamente, como nome, e-mail, CPF e dados escolares, ao criar uma conta ou utilizar nossos serviços de planejamento e diário de classe.
                    </p>
                </div>

                <!-- Section 2 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-cyan-100 dark:bg-cyan-900/50 flex items-center justify-center text-cyan-600 dark:text-cyan-400">
                            <x-icon name="server" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">2. Uso das Informações</h2>
                    </div>
                    <ul class="space-y-3 pl-16 text-slate-600 dark:text-slate-400 leading-relaxed list-disc">
                        <li>Para fornecer e manter nosso serviço educacional;</li>
                        <li>Para notificar sobre alterações em nossa plataforma;</li>
                        <li>Para fornecer suporte ao cliente;</li>
                        <li>Para monitorar o uso do serviço e detectar problemas técnicos.</li>
                    </ul>
                </div>

                <!-- Section 3 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <x-icon name="lock" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">3. Segurança de Dados</h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed pl-16">
                        A segurança dos seus dados é importante para nós. Utilizamos protocolos de criptografia e práticas de segurança padrão da indústria para proteger suas informações pessoais contra acesso não autorizado.
                    </p>
                </div>

                <!-- Section 4 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-900/50 flex items-center justify-center text-teal-600 dark:text-teal-400">
                            <x-icon name="cookie" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">4. Cookies</h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed pl-16">
                        Utilizamos cookies para rastrear a atividade em nosso serviço e reter certas informações para melhorar sua experiência de navegação e personalizar o conteúdo.
                    </p>
                </div>

                <!-- Divider -->
                <hr class="border-slate-100 dark:border-slate-800 my-8">

                <!-- Contact -->
                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Dúvidas sobre Privacidade?</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Entre em contato com nosso Encarregado de Dados (DPO).</p>
                    </div>
                    <a href="{{ route('contact') }}" class="px-6 py-3 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all shadow-sm">
                        Entrar em Contato
                    </a>
                </div>

            </div>
        </main>

        <x-HomePage::footer />
    </div>
</x-layouts.guest>
