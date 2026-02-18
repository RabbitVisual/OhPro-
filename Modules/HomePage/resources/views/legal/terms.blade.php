<x-layouts.guest title="Termos de Uso — Oh Pro!">
    <div class="relative min-h-screen bg-slate-50 dark:bg-slate-950 overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-purple-600/10 blur-[120px] rounded-full pointer-events-none"></div>

        <!-- Navbar -->
        <x-HomePage::navbar />

        <main class="relative z-10 container mx-auto px-4 py-24 sm:py-32">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 font-semibold text-sm border border-purple-200 dark:border-purple-800">
                    <x-icon name="file-contract" style="duotone" />
                    <span>Última atualização: 07 de Fevereiro de 2026</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-slate-900 dark:text-white">
                    Termos de Uso
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400">
                    Por favor, leia atentamente estes termos antes de utilizar a plataforma Oh Pro!
                </p>
            </div>

            <!-- Content Card -->
            <div class="max-w-4xl mx-auto bg-white dark:bg-slate-900 rounded-3xl p-8 sm:p-12 shadow-xl border border-slate-100 dark:border-slate-800 space-y-12">

                <!-- Section 1 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400">
                            <x-icon name="handshake" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">1. Aceitação dos Termos</h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed pl-16">
                        Ao acessar e utilizar a plataforma Oh Pro!, você concorda em cumprir e ficar vinculado aos seguintes termos e condições de uso. Se você não concordar com qualquer parte destes termos, você não deve utilizar nossos serviços.
                    </p>
                </div>

                <!-- Section 2 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <x-icon name="user-shield" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">2. Conta do Usuário</h2>
                    </div>
                    <ul class="space-y-3 pl-16 text-slate-600 dark:text-slate-400 leading-relaxed list-disc">
                        <li>Você é responsável por manter a confidencialidade de sua conta e senha.</li>
                        <li>Você concorda em fornecer informações verdadeiras, exatas, atuais e completas durante o processo de registro.</li>
                        <li>O uso da conta é pessoal e intransferível.</li>
                    </ul>
                </div>

                <!-- Section 3 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <x-icon name="chalkboard-user" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">3. Uso da Plataforma</h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed pl-16">
                        A plataforma destina-se a apoiar atividades educacionais. Você concorda em não usar o serviço para qualquer finalidade ilegal ou não autorizada. O compartilhamento de materiais deve respeitar os direitos autorais e a propriedade intelectual de terceiros.
                    </p>
                </div>

                <!-- Section 4 -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-100 dark:bg-rose-900/50 flex items-center justify-center text-rose-600 dark:text-rose-400">
                            <x-icon name="ban" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">4. Cancelamento e Rescisão</h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed pl-16">
                        Podemos encerrar ou suspender seu acesso imediatamente, sem aviso prévio ou responsabilidade, por qualquer motivo, inclusive se você violar os Termos.
                    </p>
                </div>

                <!-- Divider -->
                <hr class="border-slate-100 dark:border-slate-800 my-8">

                <!-- Contact -->
                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ainda tem dúvidas?</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Nossa equipe jurídica está à disposição para esclarecimentos.</p>
                    </div>
                    <a href="{{ route('contact') }}" class="px-6 py-3 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:border-purple-500 dark:hover:border-purple-500 transition-all shadow-sm">
                        Entrar em Contato
                    </a>
                </div>

            </div>
        </main>

        <x-HomePage::footer />
    </div>
</x-layouts.guest>
