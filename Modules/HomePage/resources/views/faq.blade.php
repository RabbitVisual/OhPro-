<x-layouts.guest title="FAQ — Oh Pro!">
    <div class="relative min-h-screen bg-white dark:bg-slate-950 font-sans">
        {{-- Background: blur leve para evitar travamento --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-500/10 dark:bg-indigo-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[350px] h-[350px] bg-purple-500/10 dark:bg-purple-900/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <x-HomePage::navbar />

        <main class="relative z-10 container mx-auto px-4 py-16 sm:py-24 max-w-6xl">
            {{-- Header --}}
            <header class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 font-semibold text-sm border border-indigo-100 dark:border-indigo-800 mb-6">
                    <x-icon name="circle-question" style="duotone" class="fa-sm" />
                    <span>Perguntas frequentes</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-slate-900 dark:text-white tracking-tight mb-4">
                    Tire suas dúvidas sobre o <span class="text-transparent bg-clip-text bg-linear-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Oh Pro!</span>
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Workspace, planos de aula, notas, chamada e diário com assinatura. Veja como cada recurso funciona.
                </p>
            </header>

            <div x-data="{ activeCategory: 'geral' }" class="space-y-12">
                {{-- Navegação por categoria --}}
                <nav class="flex flex-wrap justify-center gap-3" role="tablist">
                    @foreach([
                        'geral' => ['label' => 'Geral', 'icon' => 'circle-info'],
                        'uso' => ['label' => 'Uso no dia a dia', 'icon' => 'chalkboard-user'],
                        'conta' => ['label' => 'Conta e segurança', 'icon' => 'shield-check'],
                        'planos' => ['label' => 'Planos e suporte', 'icon' => 'key'],
                    ] as $id => $cat)
                        <button
                            type="button"
                            @click="activeCategory = '{{ $id }}'"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border-2 text-sm font-semibold transition-colors"
                            :class="activeCategory === '{{ $id }}'
                                ? 'bg-indigo-600 border-indigo-600 text-white'
                                : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-indigo-300 dark:hover:border-indigo-800'"
                        >
                            <x-icon :name="$cat['icon']" style="duotone" class="fa-sm" />
                            {{ $cat['label'] }}
                        </button>
                    @endforeach
                </nav>

                {{-- Conteúdo: uma seção por categoria --}}
                <div class="bg-slate-50/80 dark:bg-slate-900/80 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 min-h-[400px]">
                    {{-- GERAL --}}
                    <div x-show="activeCategory === 'geral'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak style="display: none;">
                        <h2 class="text-xl font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="circle-info" style="duotone" class="text-indigo-500" />
                            Conceitos gerais
                        </h2>
                        @php
                            $geral = [
                                ['q' => 'O que é o Oh Pro!?', 'a' => 'Oh Pro! é o caderno digital do professor. Reúne em um só lugar: workspace com escolas e turmas, planos de aula, notas em planilha, chamada rápida, diário de classe com assinatura digital e o widget da próxima aula. Tudo pensado para o fluxo real do professor.'],
                                ['q' => 'Para quem é o sistema?', 'a' => 'Para professores de qualquer etapa: Educação Básica ou Ensino Superior. Quem tem várias escolas ou turmas, precisa lançar notas, fazer chamada e manter diário com assinatura encontra no Oh Pro! um único ambiente organizado.'],
                                ['q' => 'Como o Oh Pro! ajuda a economizar tempo?', 'a' => 'Evitando fragmentação: em vez de planilhas soltas, documentos em vários lugares e diário em papel, você usa um único workspace. Troca de escola com um clique, acessa a turma e faz notas, chamada e diário no mesmo fluxo. O sistema salva as notas ao sair do campo e o widget da próxima aula lembra o que vem a seguir.'],
                                ['q' => 'O professor mantém autonomia?', 'a' => 'Sim. O Oh Pro! não impõe conteúdo nem metodologia. Você cria seus planos, define pesos das avaliações, preenche o diário e assina quando concluir. O sistema é a ferramenta; você decide como usar.'],
                            ];
                        @endphp
                        @foreach($geral as $i => $faq)
                            @include('HomePage::faq-item', ['faq' => $faq, 'id' => 'geral-' . $i])
                        @endforeach
                    </div>

                    {{-- USO NO DIA A DIA --}}
                    <div x-show="activeCategory === 'uso'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak style="display: none;">
                        <h2 class="text-xl font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="chalkboard-user" style="duotone" class="text-indigo-500" />
                            Uso no dia a dia
                        </h2>
                        @php
                            $uso = [
                                ['q' => 'Como funciona o Workspace?', 'a' => 'No painel você vê "Minhas escolas" (botões para trocar de escola), a barra de cor da escola selecionada e o bloco "Turmas" com cards por turma. Cada card leva à página da turma, onde você acessa notas, chamada, diário e pode iniciar a aula. O botão "Planos de aula" no topo leva ao módulo de planos.'],
                                ['q' => 'Como criar e usar planos de aula?', 'a' => 'Em "Planos de aula" você cria planos com templates (simples ou detalhado). Pode vincular o plano à turma. Ao "Iniciar Aula" no workspace, o plano aplicado àquela turma pode ser usado para preencher o registro do diário. Os templates permitem objetivos, conteúdo, duração e, no detalhado, competências e recursos.'],
                                ['q' => 'Como funcionam as notas?', 'a' => 'Dentro de cada turma há a planilha de notas. Você define avaliações (por exemplo Av1, Av2, Av3) e pesos; o sistema calcula a média ponderada. As notas são salvas automaticamente ao sair do campo. A interface é pensada para uso em celular (toque amigável).'],
                                ['q' => 'Como fazer a chamada?', 'a' => 'Pela turma você acessa a chamada. Os alunos aparecem em cards; um toque marca presente ou ausente (ícones verde e vermelho). A chamada é por dia, de forma rápida e visual.'],
                                ['q' => 'O que é o diário de classe com assinatura?', 'a' => 'O diário registra o que foi dado na aula. Você inicia a aula a partir do workspace (ou pelo widget "Sua Próxima Aula"), preenche o registro e, ao finalizar, assina digitalmente. A assinatura fica registrada com data e hora, atendendo à exigência de documentação.'],
                                ['q' => 'O que é o widget "Sua Próxima Aula"?', 'a' => 'No dashboard do workspace aparece um bloco com a próxima aula agendada (turma, data e hora). De lá você pode "Iniciar Aula", "Fazer Chamada" ou "Ver plano", sem precisar procurar a turma. Se não houver horários cadastrados, o sistema informa que não há aula agendada.'],
                            ];
                        @endphp
                        @foreach($uso as $i => $faq)
                            @include('HomePage::faq-item', ['faq' => $faq, 'id' => 'uso-' . $i])
                        @endforeach
                    </div>

                    {{-- CONTA E SEGURANÇA --}}
                    <div x-show="activeCategory === 'conta'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak style="display: none;">
                        <h2 class="text-xl font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="shield-check" style="duotone" class="text-indigo-500" />
                            Conta e segurança
                        </h2>
                        @php
                            $conta = [
                                ['q' => 'O que significa "Local-First"?', 'a' => 'A interface é leve e responsiva, pensada para responder rápido no navegador mesmo com internet instável (comum em escolas). As ações principais não dependem de carregar muita coisa do servidor a cada clique.'],
                                ['q' => 'Como meus dados são protegidos?', 'a' => 'Utilizamos boas práticas de segurança e armazenamento. Os dados são tratados em conformidade com a LGPD. Não vendemos dados; o uso é para operação do serviço e melhoria do produto.'],
                                ['q' => 'Como recupero minha senha?', 'a' => 'Na tela de login, clique em "Esqueci minha senha". Informe o e-mail cadastrado e você receberá um link seguro para redefinir a senha.'],
                                ['q' => 'Funciona em celular ou tablet?', 'a' => 'Sim. O layout é responsivo e a planilha de notas e a chamada foram pensadas para uso em telas menores e toque.'],
                            ];
                        @endphp
                        @foreach($conta as $i => $faq)
                            @include('HomePage::faq-item', ['faq' => $faq, 'id' => 'conta-' . $i])
                        @endforeach
                    </div>

                    {{-- PLANOS E SUPORTE --}}
                    <div x-show="activeCategory === 'planos'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak style="display: none;">
                        <h2 class="text-xl font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="key" style="duotone" class="text-indigo-500" />
                            Planos e suporte
                        </h2>
                        @php
                            $planos = [
                                ['q' => 'Como funciona o período de teste?', 'a' => 'Você pode criar sua conta e explorar o Oh Pro! gratuitamente. Consulte a página de planos ou a área logada para condições de teste e planos pagos.'],
                                ['q' => 'Há descontos para escolas ou redes?', 'a' => 'Para múltiplos professores ou instituições, entre em contato. Temos opções que podem se adaptar a escolas e redes.'],
                                ['q' => 'Como falo com o suporte?', 'a' => 'Use a página "Contato" para enviar sua mensagem. Nossa equipe responde em horário comercial (Segunda a Sexta).'],
                            ];
                        @endphp
                        @foreach($planos as $i => $faq)
                            @include('HomePage::faq-item', ['faq' => $faq, 'id' => 'planos-' . $i])
                        @endforeach
                    </div>
                </div>

                {{-- CTA Suporte --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-900 dark:bg-slate-800 p-8 text-center text-white">
                    <p class="text-lg font-semibold mb-2">Não encontrou a resposta?</p>
                    <p class="text-slate-300 dark:text-slate-400 text-sm mb-6">Nossa equipe está pronta para ajudar.</p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl font-semibold transition-colors">
                        <x-icon name="envelope" style="duotone" class="fa-sm" />
                        Falar com o suporte
                    </a>
                </div>

                {{-- CTA Final --}}
                <div class="rounded-2xl bg-indigo-600 text-white p-8 sm:p-10 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-2xl translate-x-1/2 -translate-y-1/2"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icon name="rocket-launch" style="duotone" size="xl" />
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-display font-bold mb-2">Comece a usar o Oh Pro!</h2>
                        <p class="text-indigo-100 text-sm sm:text-base mb-6 max-w-lg mx-auto">Workspace, planos, notas, chamada e diário com assinatura em um só lugar.</p>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold transition-all hover:bg-indigo-50">
                            <x-icon name="user-plus" style="duotone" class="fa-sm" />
                            Criar conta grátis
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <x-HomePage::footer />
    </div>
</x-layouts.guest>
