<div class="min-h-screen p-4 md:p-6">
    {{-- Next class widget --}}
    <livewire:workspace.next-class-widget />

    {{-- School selector with color feedback --}}
    <div class="mb-6">
        <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
            <x-icon name="school" style="duotone" />
            Minhas escolas
        </h2>
        <div class="flex flex-wrap gap-2">
            @foreach($this->schools as $school)
                @php
                    $isSelected = $school->id === $currentSchoolId;
                    $schoolColor = $school->color ?: '#6366f1';
                @endphp
                <button
                    type="button"
                    wire:click="switchSchool({{ $school->id }})"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 text-sm font-medium transition-all
                        {{ $isSelected
                            ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                            : 'bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600' }}"
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
        <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="chalkboard-user" style="duotone" />
            Turmas{{ $this->currentSchool ? ' - ' . $this->currentSchool->name : '' }}
        </h2>
        <div class="flex gap-2">
            <a
                href="{{ route('planning.index') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600"
            >
                <x-icon name="book-open-reader" style="duotone" class="fa-sm" />
                Planos de aula
            </a>
        </div>
    </div>

    @if($this->classes->isEmpty())
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center text-gray-500 dark:text-gray-400">
            <x-icon name="chalkboard-user" style="duotone" class="fa-3x mx-auto mb-3 opacity-50" />
            <p class="font-medium">Nenhuma turma nesta escola.</p>
            <p class="text-sm mt-1">Adicione uma turma para começar.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->classes as $class)
                <a
                    href="{{ route('workspace.show', $class) }}"
                    class="block rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors"
                >
                    <h3 class="font-display font-semibold text-gray-900 dark:text-white">{{ $class->name }}</h3>
                    @if($class->subject || $class->grade_level)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ implode(' · ', array_filter([$class->grade_level, $class->subject])) }}
                        </p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
