<x-layouts.guest title="Fale Conosco — Oh Pro!">
    <div class="relative min-h-screen bg-slate-50 dark:bg-slate-950 overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-indigo-600/5 blur-[120px] rounded-l-full pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-full bg-purple-600/5 blur-[120px] rounded-r-full pointer-events-none"></div>

        <!-- Navbar -->
        <x-HomePage::navbar />

        <main class="relative z-10 container mx-auto px-4 py-24 sm:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                <!-- Left Column: Info -->
                <div class="space-y-12">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-semibold text-sm border border-indigo-200 dark:border-indigo-800">
                            <x-icon name="headset" style="duotone" />
                            <span>Suporte Especializado</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-display font-bold text-slate-900 dark:text-white leading-tight">
                            Como podemos ajudar você hoje?
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-400">
                            Nossa equipe está pronta para tirar suas dúvidas, ouvir suas sugestões ou resolver qualquer problema que você possa ter.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none">
                            <div class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-4">
                                <x-icon name="envelope" style="duotone" size="xl" />
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">E-mail</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mb-4">Para assuntos gerais.</p>
                            <a href="mailto:contato@ohpro.app" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">contato@ohpro.app</a>
                        </div>
                        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                                <x-icon name="comments" style="duotone" size="xl" />
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Chat Online</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mb-4">Disponível em horário comercial.</p>
                            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Online Agora</span>
                        </div>
                    </div>

                    <div class="p-8 rounded-3xl bg-slate-900 dark:bg-slate-800 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/20 blur-3xl rounded-full"></div>
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-2">Dúvidas Frequentes?</h3>
                            <p class="text-slate-400 mb-6">Confira nossa base de conhecimento antes de abrir um chamado.</p>
                            <a href="{{ route('faq') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl border border-white/10 transition-colors font-medium">
                                <x-icon name="book-open" style="duotone" />
                                <span>Acessar FAQ</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Form -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-500/10 border border-slate-100 dark:border-slate-800">
                    <livewire:support-create-ticket />
                </div>

            </div>
        </main>

        <x-HomePage::footer />
    </div>
</x-layouts.guest>
