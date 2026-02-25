<div x-data="{
    tourStep: 0,
    tourDone: typeof localStorage !== 'undefined' && localStorage.getItem('onboarding_tour_done'),
    tourSteps: [
        { title: 'Bem-vindo ao Oh Pro!', body: 'Configure sua conta em 3 passos rápidos. Comece criando sua primeira escola (workspace).', cta: 'Próximo' },
        { title: 'Importe seus alunos', body: 'Depois de criar uma escola e turma, importe a lista de alunos para fazer chamada e lançar notas.', cta: 'Próximo' },
        { title: 'Crie seu primeiro plano de aula', body: 'Use o módulo Planos de aula para criar e vincular planos às turmas. Você também pode gerar com IA!', cta: 'Entendi' }
    ],
    startTour() {
        this.tourDone = false;
        this.tourStep = 0;
        if (typeof localStorage !== 'undefined') localStorage.removeItem('onboarding_tour_done');
    },
    nextTour() {
        if (this.tourStep >= this.tourSteps.length - 1) {
            if (typeof localStorage !== 'undefined') localStorage.setItem('onboarding_tour_done', '1');
            this.tourDone = true;
            this.tourStep = 0;
        } else {
            this.tourStep++;
        }
    },
    closeTour() {
        if (typeof localStorage !== 'undefined') localStorage.setItem('onboarding_tour_done', '1');
        this.tourDone = true;
        this.tourStep = 0;
    }
}" x-init="if (!tourDone && typeof localStorage !== 'undefined' && !localStorage.getItem('onboarding_tour_done')) { $nextTick(() => { tourStep = 0; tourDone = false; }); }">
    @if(!$this->onboardingComplete)
        <div class="mb-6 rounded-xl border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/20 p-4">
            <h3 class="text-sm font-display font-bold text-indigo-900 dark:text-indigo-100 mb-2">Progresso de Configuração</h3>
            <div class="flex flex-wrap gap-4 items-center mb-2">
                <span class="inline-flex items-center gap-2 text-sm {{ $this->onboardingStep1 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' }}">
                    @if($this->onboardingStep1)<x-icon name="check-circle" style="solid" class="fa-sm" />@else<span class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-600 inline-flex items-center justify-center text-xs">1</span>@endif
                    Criar escola
                </span>
                <span class="inline-flex items-center gap-2 text-sm {{ $this->onboardingStep2 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' }}">
                    @if($this->onboardingStep2)<x-icon name="check-circle" style="solid" class="fa-sm" />@else<span class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-600 inline-flex items-center justify-center text-xs">2</span>@endif
                    Importar alunos
                </span>
                <span class="inline-flex items-center gap-2 text-sm {{ $this->onboardingStep3 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' }}">
                    @if($this->onboardingStep3)<x-icon name="check-circle" style="solid" class="fa-sm" />@else<span class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-600 inline-flex items-center justify-center text-xs">3</span>@endif
                    Criar plano de aula
                </span>
            </div>
            @php $pct = ($this->onboardingStep1 ? 33 : 0) + ($this->onboardingStep2 ? 33 : 0) + ($this->onboardingStep3 ? 34 : 0); @endphp
            <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                <div class="h-full bg-indigo-600 dark:bg-indigo-500 rounded-full transition-all duration-300" style="width: {{ $pct }}%"></div>
            </div>
        </div>
    @endif
    @if($this->atPlanLimit)
        <div class="mb-6 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 flex flex-wrap items-center justify-between gap-3">
            <p class="text-amber-800 dark:text-amber-200 text-sm font-medium">Você atingiu o limite de turmas do plano Gratuito. Faça upgrade para criar mais turmas.</p>
            <a href="{{ route('plans') }}" class="shrink-0 px-4 py-2 rounded-lg bg-amber-600 text-white text-sm font-medium hover:bg-amber-700">Ver planos</a>
        </div>
    @endif
    {{-- Financial overview --}}
    <livewire:workspace.financial-overview-widget />
    {{-- At-risk students widget --}}
    <livewire:classrecord.at-risk-widget />
    {{-- Next class widget --}}
    <livewire:workspace.next-class-widget />

    {{-- Weekly agenda (Mon–Fri) --}}
    <livewire:workspace.weekly-agenda />

    {{-- School selector with color feedback --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <x-icon name="school" style="duotone" class="text-indigo-600 dark:text-indigo-400" />
                Minhas escolas
            </h2>
            <button
                type="button"
                @click="$dispatch('open-create-school')"
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-medium hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors"
            >
                <x-icon name="plus" class="w-4 h-4" />
                Criar Escola
            </button>
        </div>
        <div class="flex flex-wrap gap-2">
            @foreach($this->schools as $school)
                @php
                    $isSelected = $school->id === $currentSchoolId;
                    $schoolColor = $school->color ?: '#6366f1';
                @endphp
                <button
                    type="button"
                    wire:click="switchSchool({{ $school->id }})"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border-2 text-sm font-medium transition-all
                        {{ $isSelected
                            ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border-slate-200 dark:border-slate-700'
                            : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-600' }}"
                    style="{{ $isSelected ? "border-left-color: {$schoolColor}; border-left-width: 4px;" : '' }}"
                >
                    <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $schoolColor }}"></span>
                    {{ $school->short_name ?: $school->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Accent bar using current school color --}}
    @if($this->currentSchool)
        <div
            class="h-1 rounded-full mb-6"
            style="background-color: {{ $this->currentSchool->color ?: '#6366f1' }}"
        ></div>
    @endif

    {{-- Classes grid --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-2">
        <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <x-icon name="chalkboard-user" style="duotone" class="text-indigo-600 dark:text-indigo-400" />
            Turmas{{ $this->currentSchool ? ' - ' . $this->currentSchool->name : '' }}
        </h2>
        <div class="flex gap-2">
            <button
                type="button"
                @click="$dispatch('open-create-class')"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 shadow-sm shadow-indigo-200 dark:shadow-none"
            >
                <x-icon name="plus" class="fa-sm" />
                Nova Turma
            </button>
            @if(auth()->user()->isPro())
            <a
                href="{{ route('workspace.import') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
            >
                <x-icon name="file-import" style="duotone" class="fa-sm" />
                Importar alunos
            </a>
            <a
                href="{{ route('google.redirect') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
            >
                <x-icon name="google" :brand="true" class="fa-sm text-red-500" />
                Sincronizar Google
            </a>
            @else
            <x-feature-locked feature="Importar alunos" />
            @endif
            <a
                href="{{ route('planning.index') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
            >
                <x-icon name="book-open-reader" style="duotone" class="fa-sm" />
                Planos de aula
            </a>
            <a
                href="{{ route('library.index') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
            >
                <x-icon name="folder-open" style="duotone" class="fa-sm" />
                Biblioteca
            </a>
            <a
                href="{{ route('profile.edit') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
            >
                <x-icon name="id-card" style="duotone" class="fa-sm" />
                Marca pessoal
            </a>
        </div>
    </div>

    @if($this->classes->isEmpty())
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-8 text-center text-slate-500 dark:text-slate-400 shadow-sm">
            <x-icon name="chalkboard-user" style="duotone" class="w-12 h-12 mx-auto mb-3 text-slate-400 dark:text-slate-500" />
            <p class="font-medium">Nenhuma turma nesta escola.</p>
            <p class="text-sm mt-1">Adicione uma turma para começar.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->classes as $class)
                <a
                    href="{{ route('workspace.show', $class) }}"
                    class="block rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 hover:border-indigo-300 dark:hover:border-indigo-600 hover:shadow-md transition-all group relative"
                >
                    <div class="flex items-start justify-between">
                        <h3 class="font-display font-semibold text-slate-900 dark:text-white">{{ $class->name }}</h3>
                        @if(!$class->isOwner(auth()->user()))
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200" title="Turma Compartilhada">
                                <x-icon name="users-gear" style="duotone" class="w-3 h-3 mr-1" />
                                Compartilhada
                            </span>
                        @else
                            {{-- Edit Button (Visible on Hover) --}}
                            <button
                                type="button"
                                wire:click.stop="$dispatch('open-edit-class', { classId: {{ $class->id }} })"
                                class="absolute top-2 right-2 p-1.5 rounded-full bg-white dark:bg-slate-700 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity"
                                title="Editar Turma"
                            >
                                <x-icon name="pen-to-square" class="w-3.5 h-3.5" />
                            </button>
                        @endif
                    </div>
                    @if($class->subject || $class->grade_level)
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            {{ implode(' · ', array_filter([$class->grade_level, $class->subject])) }}
                        </p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    {{-- Welcome tour (Alpine) --}}
    <template x-teleport="body">
        <div x-show="!tourDone && tourStep < tourSteps.length" x-cloak
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div x-show="!tourDone && tourStep < tourSteps.length" x-transition
                 class="w-full max-w-md rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-xl p-6">
                <h3 class="text-lg font-display font-bold text-slate-900 dark:text-white" x-text="tourSteps[tourStep]?.title"></h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400" x-text="tourSteps[tourStep]?.body"></p>
                <div class="mt-6 flex justify-between items-center">
                    <button type="button" @click="closeTour()" class="text-sm text-slate-500 dark:text-slate-400 hover:underline">Pular</button>
                    <button type="button" @click="nextTour()" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700" x-text="tourSteps[tourStep]?.cta"></button>
                </div>
                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500" x-text="(tourStep + 1) + ' de ' + tourSteps.length"></p>
            </div>
        </div>
    </template>

    {{-- Creation/Edit Modals --}}
    <livewire:workspace.create-school />
    <livewire:workspace.create-class />
    <livewire:workspace.edit-school />
    <livewire:workspace.edit-class />
</div>
