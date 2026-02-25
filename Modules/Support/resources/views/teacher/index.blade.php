<x-layouts.app-sidebar :title="$title ?? 'Suporte'">
    <div>
        <livewire:support::ticket-manager />

        <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700">
            <h3 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-6">Perguntas Frequentes (FAQ)</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- FAQ Item 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                        <x-icon name="file-import" class="w-4 h-4 text-indigo-500" />
                        Como importar meus alunos?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Vá até o Workspace da sua escola, clique em "Minhas Turmas" e selecione a opção "Importar Alunos". Você pode usar um arquivo CSV ou colar os nomes diretamente.
                    </p>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                         <x-icon name="wand-magic-sparkles" class="w-4 h-4 text-amber-500" />
                        Como funciona o Assistente de IA?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        O Vertex IA ajuda a criar planos de aula e atividades. Basta descrever o tema e a faixa etária. O limite de gerações depende do seu plano atual.
                    </p>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                         <x-icon name="credit-card" class="w-4 h-4 text-emerald-500" />
                        Como faço upgrade para o plano Pro?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Acesse "Minha Conta" > "Assinatura" ou entre em contato com o administrador da escola. O plano Pro libera gerações ilimitadas e relatórios avançados.
                    </p>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                         <x-icon name="shield-check" class="w-4 h-4 text-gray-500" />
                        Minha senha é segura?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sim, utilizamos criptografia avançada. Recomendamos ativar a autenticação de dois fatores (em breve) e não compartilhar sua senha com ninguém.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
